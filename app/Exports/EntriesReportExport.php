<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EntriesReportExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $report_data = null;

    public function __construct($data)
    {
        $this->report_data = $data;
    }


    public function view(): View
    {
        return view('export.entries_report_export', [
            'report_data' => $this->report_data
        ]);
    }

    
}
