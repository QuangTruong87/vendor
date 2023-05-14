<?php
namespace Foostart\Pexcel\Helper;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Foostart\Pexcel\Helper\User\UserImport;

class UserOnlineTdcImport implements ToCollection
{
    use Importable;

    public function collection(Collection $rows)
    {
        $data = [];
        foreach ($rows as $row)
        {

            $data[] = $row->toArray();
        }
        $studentInfo = $this->getStudentInfo($data);

        $userImport = new UserImport();
        $userImport->importUsers($studentInfo);

    }

    /**
     *
     * Sample 4
     * http://online.tdc.edu.vn
     * @param $data
     */
    public function getStudentInfo($data) {
        $info = [
            'order' => 0,
            'user_name' => 1,
            'first_name' => 2,
            'last_name' => 3,
        ];

        $studentInfo = [];

        $rangeData = $this->getRangeData($data);

        if (!empty($rangeData) && is_array($rangeData)) {
            for ($i = 0; $i < count($rangeData); $i++) {
                $studentInfo[] = [
                    'order' => $rangeData[$i][$info['order']],
                    'email' => $rangeData[$i][$info['user_name']] . '@mail.tdc.edu.vn',
                    'user_name' => $rangeData[$i][$info['user_name']],
                    'first_name' => $rangeData[$i][$info['first_name']],
                    'last_name' => $rangeData[$i][$info['last_name']],
                ];
            }
        }
        return $studentInfo;
    }

    private function getRangeData($data) {
        $rangeData = [];
        if (!empty($data) && is_array($data)) {
            for ($i = 0; $i < count($data); $i++) {
                if ($this->isFourInfo($data[$i])) {
                    $rangeData[] = $data[$i];
                }
            }
        }
        return $rangeData;
    }

    /**
     * Check valid row: four info in row
     * @param $row
     */
    private function isFourInfo($row) {

        $flag = false;
        if (!empty($row) && is_array($row)) {
            $flag = true;
            // More 4 items
            if (count($row) <= 4) {
                $flag = false;
            } else {
                for ($i = 0; $i < 4; $i++) {
                    if (empty($row[$i])) {
                        $flag = false;
                        break;
                    }
                }
                if ($flag) {
                    for ($i = 4; $i < count($row); $i++) {
                        if (!empty($row[$i])) {
                            $flag = false;
                            break;
                        }
                    }
                }
            }

        }
        return $flag;
    }
}
