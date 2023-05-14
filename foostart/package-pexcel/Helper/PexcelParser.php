<?php

namespace Foostart\Pexcel\Helper;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Foostart\Pexcel\Helper\UserPexcelParser;

class PexcelParser implements  FromCollection
{
    use Exportable;

    public function collection()
    {

    }
    public function isValidFile($file_path)
    {

        $flag = TRUE;
        return $flag;
    }
    /**
     * Read file excel
     * Read first sheet
     * @param type $pexcel
     * @return type
     */
    public function read_data($pexcel, $type)
    {

        $pexcel_files = json_decode($pexcel->pexcel_file_path);

        $pexcel_file_path = realpath(base_path('public/' . $pexcel_files[0]));

        if ($type == 'user') {
            $obj_user = new UserPexcelParser();
            $obj_user->read_data();
        }

        $data = array();

        $excel = \App::make('excel');

        $data = \Excel::selectSheetsByIndex(0)->load($pexcel_file_path, function ($reader) {
            // Getting all results
            $reader->noHeading();

            $reader->formatDates(false);
        }, 'UTF-8')->get();
        $results = $data->toArray();

        $raw_data = $this->parseExcel($results);

        return $raw_data;
    }
    private function parseExcel($filedata) {
        $data = array();

        $from_row = 1;
        $to_row = 5;

        $fields = config('package-pexcel.fields');

        for ($index = $from_row; $index < $to_row; $index++) {

            $value = $filedata[$index];


            $data[] = $this->mapData($fields, $value);
        }
        return $data;
    }
    /**
     * Map data excel with configs
     * @param type $fields
     * @param type $value
     * @param type $pexcel
     * @return type
     */
    private function mapData($fields, $value)
    {
        $data = [];

        foreach ($fields as $key => $index) {

            $data[$key] = NULL;
            if (isset($value[$index - 1])) {

                $data[$key] = $value[$index-1];

            }
        }
        return $data;
    }

    public function export_data($data, $file_name)
    {
        \Excel::create($file_name . '_' . date('d-m-Y', time()), function ($excel) use ($data) {

            $excel->sheet('pexels', function ($sheet) use ($data) {

                $sheet->appendRow(array(
                    'Pexcel ID',
                    'Pexcel ID',
                    'Pexcel ID',
                    'Pexcel ID',
                    'Pexcel name',
                    'Created at',
                    'File path'
                ));
                foreach ($data as $item) {
                    $sheet->appendRow(array(
                        $item->pexcel_id,
                        $item->pexcel_id,
                        $item->pexcel_id,
                        $item->pexcel_id,
                        $item->pexcel_name,
                        date('d-m-Y', $item->pexcel_created_at),
                        $item->pexcel_file_path
                    ));
                }
            });
        })->download('xlsx');
    }

    public function export_items($items = []) {

        $temp = realpath(base_path('/files/1/1-pexcels/thong-ke-viec-lam.xls'));

        $columns =  ['A' => 'A', 'B' => 'B', 'C' => 'C' , 'D' => 'D', 'E' => 'E', 'F' => 'F'];

        $fromrow = 2;

        $data = [
            '0' => [
                'A' => 'a',
                'B' => 'b',
                'C' => 'c',
                'D' => 'd',
                'E' => 'e',
                'f' => 'f',
            ],
            '1' => [
                'A' => 'a',
                'B' => 'b',
                'C' => 'c',
                'D' => 'd',
                'E' => 'e',
                'f' => 'f',
            ]
        ];

        \Excel::load($temp, function ($excel) use ($data, $columns, $fromrow) {

            $fields = array_keys($columns);

            $sheet = $excel->setActiveSheetIndex(0);

            foreach ($data as $items) {

                foreach ($items as $key => $value) {

                    if (in_array($key, $fields)) {

                        $cell = $columns[$key].$fromrow;

                        $sheet->setCellValue($cell, $value);

                    }

                }
                $fromrow++;
            }

        })->download('xlsx');
    }



}
