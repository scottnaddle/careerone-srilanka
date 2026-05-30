    public function table(Table $table): Table
    {
        $query = $this->getCareerTestTraineeResultsQuery($this->record);

        return $table
            ->query($query)
            ->defaultSort('updated_at', 'desc')
            ->columns([
                TextColumn::make('test_type')
                    ->label(__('admin/career_test.career_test.table.career_test'))
                    ->getStateUsing(function ($record) {
                        return getCodeNameByCodeId('career_test_type', $record->careerTest->test_type) ?? 'N/A';
                    })->sortable(),
                TextColumn::make('institute.name')
                    ->label(__('admin/career_test.career_test.table.trainee_institute')),
                TextColumn::make('fullName')
                    ->label(__('admin/career_test.career_test.table.trainee_name'))
                    ->getStateUsing(function ($record) {
                        return $record->name ?? '';
                    }),
                TextColumn::make('created_at')
                    ->label(__('admin/career_test.career_test.table.date_of_test'))
                    ->date()
                    ->sortable(),
                TextColumn::make('approval')
                    ->label(__('admin/career_test.career_test.table.result'))
                    ->getStateUsing(function ($record) {
                        return in_array($record->test_type, [1, 2]) ? 'View More' : 'Download';
                    })
                    ->formatStateUsing(function ($state, $record) {
                        if ($state === 'View More') {
                            return "<a target='_blank' href='" . route('admin.career-test.view-result', ['id' => $record->id]) . "'
                                        class='text-blue-500 flex items-center gap-1 font-medium'>"
                                        . __('admin/career_test.career_test.view_details') . "
                                        <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24'
                                            stroke-width='2' stroke='currentColor' class='size-5'>
                                            <path stroke-linecap='round' stroke-linejoin='round' d='M9 5l7 7-7 7' />
                                        </svg></a>";
                        }
                        return "<a href='" . route('admin.career-test.download-result', ['id' => $record->id]) . "' target='_blank'
                                    class='text-primary text-base flex items-center gap-1'>$state
                                    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24'
                                        stroke-width='1.5' stroke='currentColor' class='size-4'>
                                        <path stroke-linecap='round' stroke-linejoin='round'
                                            d='M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3' />
                                    </svg></a>";
                    })
                    ->html(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('test_type')
                    ->preload()
                    ->options(function () {
                        return getCodeList('career_test_type')->pluck('code_name', 'code_id')->toArray();
                    })
                    ->searchable()
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value'])) {
                            $query->whereHas('careerTest', function ($q) use ($data) {
                                $q->where('test_type', $data['value']);
                            });
                        }
                    }),
            ])
            ->paginated([10, 25, 50, 100]);
    }