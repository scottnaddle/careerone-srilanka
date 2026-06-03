<?php
//
//namespace App\Livewire;
//
//use Filament\Forms\Concerns\InteractsWithForms;
//use Filament\Tables\Concerns\InteractsWithTable;
//use Filament\Forms\Contracts\HasForms;
//use Filament\Tables\Actions\Contracts\HasTable;
//use Livewire\Component;
//use Filament\Tables;
//use Filament\Tables\Table;
//use App\Models\Job;
//
//class ListJobCompany extends Component implements HasTable, HasForms
//{
//    use InteractsWithTable, InteractsWithForms;
//    public function render()
//    {
//        return view('livewire.list-job-company')->layout('components.layouts.app');
//    }
////    public function table(Table $table): Table
////    {
////        return $table
////            ->query(Job::query())
////            ->columns([
////                Tables\Columns\TextColumn::make('No.')
////                    ->label('No.')
////                    ->getStateUsing(function ($rowLoop, $record) {
////                        return $rowLoop->iteration;
////                    }),
////                Tables\Columns\TextColumn::make('created_at')->label('Date')->color('red'),
////                Tables\Columns\TextColumn::make('title')->label('Job Posting'),
////                Tables\Columns\TextColumn::make('appliesTypeApply')->label('Applied')
////                    ->counts('appliesTypeApply'),
////                Tables\Columns\TextColumn::make('appliesTypeMatch')->label('Matched')
////                    ->counts('appliesTypeMatch'),
////            ])
////            ->headerActions([
////                Tables\Actions\Action::make('jobVacancy')
////                    ->label('View more')
////                    ->url(url('admin/jobs'))
////                    ->icon('heroicon-o-chevron-right')
////                    ->iconPosition('after')
////                    ->extraAttributes([
////                        'class' => 'view-more-button',
////                    ])
////            ])
////            ->defaultPaginationPageOption(5);
////    }
//}
