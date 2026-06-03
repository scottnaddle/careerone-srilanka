<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Repeater;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Arr;
use TomatoPHP\FilamentMediaManager\Form\MediaManagerInput as BaseMediaManagerInput;

class WebpMediaManagerInput extends BaseMediaManagerInput
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->saveRelationshipsUsing(static function (Repeater $component, HasMedia $record): void {
            $mediaComponent = $component->childComponents[0] ?? null;
            $setState = $component->getState();
            $collectMediaIds = [];
            
            foreach ($setState as $getMediaItems) {
                $collectMediaIds[] = array_keys($getMediaItems['file']);
            }
            
            $getState = [];
            $record->media()->where('collection_name', $component->name)->whereNotIn('uuid', $collectMediaIds)->delete();

            $counter = 0;
            foreach ($setState as $item) {
                $state = array_filter(array_map(function (TemporaryUploadedFile | string $file) use ($mediaComponent, $record, $component, $item, $counter) {
                    if (!$file instanceof TemporaryUploadedFile) {
                        return $file;
                    }

                    if (!method_exists($record, 'addMediaFromString')) {
                        return $file;
                    }

                    try {
                        if (!$file->exists()) {
                            return null;
                        }
                    } catch (\Exception $exception) {
                        return null;
                    }
                    $mimeType = $file->getMimeType();
                    $fileContent = $file->get();
                    $filename = $mediaComponent->shouldPreserveFilenames() ? $file->getClientOriginalName() : (Str::ulid() . '.' . $file->getClientOriginalExtension());
                    if (in_array($mimeType, ['image/jpeg', 'image/png', 'image/jpg'])) {
                        $image = Image::make($fileContent);
                        $fileContent = $image->encode('webp', 80)->getEncoded();
                        $filename = pathinfo($filename, PATHINFO_FILENAME) . '.webp';
                    }
                    $mediaAdder = $record->addMediaFromString($fileContent);

                    $media = $mediaAdder
                        ->addCustomHeaders($mediaComponent->getCustomHeaders())
                        ->usingFileName($filename)
                        ->usingName($mediaComponent->getMediaName($file) ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                        ->storingConversionsOnDisk($mediaComponent->getConversionsDisk() ?? '')
                        ->withCustomProperties(collect($item)->filter(fn ($value, $key) => $key !== 'file')->toArray())
                        ->withManipulations($mediaComponent->getManipulations())
                        ->withResponsiveImagesIf($mediaComponent->hasResponsiveImages())
                        ->withProperties($mediaComponent->getProperties())
                        ->setOrder($counter)
                        ->toMediaCollection($component->name ?? 'default', $component->getDiskName());
                    $homeFolder = config('filament-media-manager.model.folder')::where('model_type', get_class($record))
                        ->where('model_id', null)
                        ->where('collection', null)
                        ->first();
                    
                    if (!$homeFolder) {
                        $data = [
                            'model_type' => get_class($record),
                            'model_id' => null,
                            'name' => Str::of(get_class($record))->afterLast('\\')->title()->toString()
                        ];
                        
                        if (filament('filament-media-manager')->allowUserAccess) {
                            $data['user_id'] = auth()->user()->id;
                            $data['user_type'] = get_class(auth()->user());
                        }
                        
                        $homeFolder = config('filament-media-manager.model.folder')::create($data);
                    }

                    $collectionFolder = config('filament-media-manager.model.folder')::where('model_type', get_class($record))
                        ->where('model_id', null)
                        ->where('collection', $component->name)
                        ->first();
                    
                    if (!$collectionFolder) {
                        $data = [
                            'collection' => $component->name,
                            'model_type' => get_class($record),
                            'name' => Str::of($component->name)->title()->toString()
                        ];
                        
                        if (filament('filament-media-manager')->allowUserAccess) {
                            $data['user_id'] = auth()->user()->id;
                            $data['user_type'] = get_class(auth()->user());
                        }
                        
                        $collectionFolder = config('filament-media-manager.model.folder')::create($data);
                    }

                    $folder = config('filament-media-manager.model.folder')::where('collection', $component->name)
                        ->where('model_type', get_class($record))
                        ->where('model_id', $record->id)
                        ->first();

                    if (!$folder) {
                        $data = [
                            'collection' => $component->name,
                            'model_type' => get_class($record),
                            'model_id' => $record->id,
                            'name' => $component->folderTitleFieldName ? $record->{$component->folderTitleFieldName} : Str::of(get_class($record))->afterLast('\\')->title()->toString() . '[' . $record->id . ']',
                        ];

                        if (filament('filament-media-manager')->allowUserAccess) {
                            $data['user_id'] = auth()->user()->id;
                            $data['user_type'] = get_class(auth()->user());
                        }

                        $folder = config('filament-media-manager.model.folder')::create($data);
                    }

                    $callback = $media->getAttributeValue('uuid');

                    if (!$callback) {
                        $file->delete();
                        return $file;
                    }

                    $storedFile = $mediaComponent->evaluate($callback, [
                        'file' => $file,
                    ]);

                    if ($storedFile === null) {
                        return null;
                    }
                    $mediaComponent->storeFileName($storedFile, $file->getClientOriginalName());
                    $file->delete();
                    return $storedFile;
                }, Arr::wrap($item['file'])));
                $item['file'] = $state;
                $getState[] = array_merge([
                    "file" => array_keys($state)[0]
                ], collect($item)->filter(fn ($value, $key) => $key !== 'file')->toArray());

                $counter++;
            }
            $component->state($getState);
        });
    }
}