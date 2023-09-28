<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AssignmentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('Assignments')->delete();
        
        \DB::table('Assignments')->insert(array (
            0 => 
            array (
                'id' => 1,
                'userId' => 2,
                'dapilDistrictId' => 2,
                'districtId' => 2251,
                'deleted_at' => '2023-09-08 05:21:42',
                'created_at' => '2023-09-08 00:42:56',
                'updated_at' => '2023-09-08 05:21:42',
            ),
            1 => 
            array (
                'id' => 2,
                'userId' => 1,
                'dapilDistrictId' => 8,
                'districtId' => 2224,
                'deleted_at' => '2023-09-08 05:44:43',
                'created_at' => '2023-09-08 05:21:11',
                'updated_at' => '2023-09-08 05:44:43',
            ),
            2 => 
            array (
                'id' => 3,
                'userId' => 2,
                'dapilDistrictId' => 8,
                'districtId' => 2225,
                'deleted_at' => '2023-09-08 05:44:36',
                'created_at' => '2023-09-08 05:22:02',
                'updated_at' => '2023-09-08 05:44:36',
            ),
            3 => 
            array (
                'id' => 4,
                'userId' => 3,
                'dapilDistrictId' => 8,
                'districtId' => 2227,
                'deleted_at' => '2023-09-08 05:44:30',
                'created_at' => '2023-09-08 05:22:19',
                'updated_at' => '2023-09-08 05:44:30',
            ),
            4 => 
            array (
                'id' => 5,
                'userId' => 5,
                'dapilDistrictId' => 9,
                'districtId' => 2229,
                'deleted_at' => '2023-09-08 05:44:25',
                'created_at' => '2023-09-08 05:24:45',
                'updated_at' => '2023-09-08 05:44:25',
            ),
            5 => 
            array (
                'id' => 6,
                'userId' => 6,
                'dapilDistrictId' => 9,
                'districtId' => 2230,
                'deleted_at' => '2023-09-08 05:44:00',
                'created_at' => '2023-09-08 05:25:07',
                'updated_at' => '2023-09-08 05:44:00',
            ),
            6 => 
            array (
                'id' => 7,
                'userId' => 4,
                'dapilDistrictId' => 8,
                'districtId' => 2245,
                'deleted_at' => '2023-09-08 05:40:09',
                'created_at' => '2023-09-08 05:36:46',
                'updated_at' => '2023-09-08 05:40:09',
            ),
            7 => 
            array (
                'id' => 8,
                'userId' => 58,
                'dapilDistrictId' => 14,
                'districtId' => 2522,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 05:45:17',
                'updated_at' => '2023-09-08 05:45:17',
            ),
            8 => 
            array (
                'id' => 9,
                'userId' => 1,
                'dapilDistrictId' => 14,
                'districtId' => 2522,
                'deleted_at' => '2023-09-09 10:56:42',
                'created_at' => '2023-09-08 05:45:40',
                'updated_at' => '2023-09-09 10:56:42',
            ),
            9 => 
            array (
                'id' => 10,
                'userId' => 60,
                'dapilDistrictId' => 14,
                'districtId' => 2531,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 05:47:01',
                'updated_at' => '2023-09-08 05:47:01',
            ),
            10 => 
            array (
                'id' => 11,
                'userId' => 61,
                'dapilDistrictId' => 14,
                'districtId' => 2531,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 05:50:16',
                'updated_at' => '2023-09-08 05:50:16',
            ),
            11 => 
            array (
                'id' => 12,
                'userId' => 30,
                'dapilDistrictId' => 2,
                'districtId' => 2281,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 05:51:37',
                'updated_at' => '2023-09-08 05:51:37',
            ),
            12 => 
            array (
                'id' => 13,
                'userId' => 31,
                'dapilDistrictId' => 2,
                'districtId' => 2258,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 05:51:59',
                'updated_at' => '2023-09-08 05:51:59',
            ),
            13 => 
            array (
                'id' => 14,
                'userId' => 32,
                'dapilDistrictId' => 2,
                'districtId' => 2268,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 05:52:20',
                'updated_at' => '2023-09-08 05:52:20',
            ),
            14 => 
            array (
                'id' => 15,
                'userId' => 33,
                'dapilDistrictId' => 2,
                'districtId' => 2259,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 05:52:38',
                'updated_at' => '2023-09-08 05:52:38',
            ),
            15 => 
            array (
                'id' => 16,
                'userId' => 34,
                'dapilDistrictId' => 2,
                'districtId' => 2252,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 05:52:55',
                'updated_at' => '2023-09-08 05:52:55',
            ),
            16 => 
            array (
                'id' => 17,
                'userId' => 35,
                'dapilDistrictId' => 3,
                'districtId' => 2282,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 05:53:19',
                'updated_at' => '2023-09-08 05:53:19',
            ),
            17 => 
            array (
                'id' => 18,
                'userId' => 36,
                'dapilDistrictId' => 3,
                'districtId' => 2263,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 05:53:39',
                'updated_at' => '2023-09-09 05:36:10',
            ),
            18 => 
            array (
                'id' => 19,
                'userId' => 40,
                'dapilDistrictId' => 3,
                'districtId' => 2262,
                'deleted_at' => '2023-09-09 05:01:47',
                'created_at' => '2023-09-08 05:54:32',
                'updated_at' => '2023-09-09 05:01:47',
            ),
            19 => 
            array (
                'id' => 20,
                'userId' => 38,
                'dapilDistrictId' => 3,
                'districtId' => 2266,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 05:54:57',
                'updated_at' => '2023-09-08 05:54:57',
            ),
            20 => 
            array (
                'id' => 21,
                'userId' => 39,
                'dapilDistrictId' => 3,
                'districtId' => 2273,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 05:55:18',
                'updated_at' => '2023-09-08 05:55:18',
            ),
            21 => 
            array (
                'id' => 22,
                'userId' => 40,
                'dapilDistrictId' => 3,
                'districtId' => 2264,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 05:55:31',
                'updated_at' => '2023-09-08 05:55:31',
            ),
            22 => 
            array (
                'id' => 23,
                'userId' => 41,
                'dapilDistrictId' => 4,
                'districtId' => 2260,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 05:55:50',
                'updated_at' => '2023-09-08 05:55:50',
            ),
            23 => 
            array (
                'id' => 24,
                'userId' => 42,
                'dapilDistrictId' => 4,
                'districtId' => 2261,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 05:56:06',
                'updated_at' => '2023-09-08 05:56:06',
            ),
            24 => 
            array (
                'id' => 25,
                'userId' => 43,
                'dapilDistrictId' => 4,
                'districtId' => 2271,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:00:12',
                'updated_at' => '2023-09-08 06:00:12',
            ),
            25 => 
            array (
                'id' => 26,
                'userId' => 44,
                'dapilDistrictId' => 4,
                'districtId' => 2277,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:00:36',
                'updated_at' => '2023-09-08 06:00:36',
            ),
            26 => 
            array (
                'id' => 27,
                'userId' => 45,
                'dapilDistrictId' => 4,
                'districtId' => 2257,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:01:21',
                'updated_at' => '2023-09-08 06:01:21',
            ),
            27 => 
            array (
                'id' => 28,
                'userId' => 46,
                'dapilDistrictId' => 4,
                'districtId' => 2280,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:01:40',
                'updated_at' => '2023-09-08 06:01:40',
            ),
            28 => 
            array (
                'id' => 29,
                'userId' => 47,
                'dapilDistrictId' => 6,
                'districtId' => 2256,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:02:32',
                'updated_at' => '2023-09-08 06:02:32',
            ),
            29 => 
            array (
                'id' => 30,
                'userId' => 48,
                'dapilDistrictId' => 6,
                'districtId' => 2278,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:02:51',
                'updated_at' => '2023-09-08 06:02:51',
            ),
            30 => 
            array (
                'id' => 31,
                'userId' => 49,
                'dapilDistrictId' => 6,
                'districtId' => 2255,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:03:07',
                'updated_at' => '2023-09-08 06:03:07',
            ),
            31 => 
            array (
                'id' => 32,
                'userId' => 50,
                'dapilDistrictId' => 6,
                'districtId' => 2254,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:03:32',
                'updated_at' => '2023-09-08 06:03:32',
            ),
            32 => 
            array (
                'id' => 33,
                'userId' => 51,
                'dapilDistrictId' => 6,
                'districtId' => 2274,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:04:05',
                'updated_at' => '2023-09-08 06:04:05',
            ),
            33 => 
            array (
                'id' => 34,
                'userId' => 52,
                'dapilDistrictId' => 7,
                'districtId' => 2251,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:04:25',
                'updated_at' => '2023-09-08 06:04:25',
            ),
            34 => 
            array (
                'id' => 35,
                'userId' => 53,
                'dapilDistrictId' => 7,
                'districtId' => 2270,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:04:49',
                'updated_at' => '2023-09-08 06:04:49',
            ),
            35 => 
            array (
                'id' => 36,
                'userId' => 54,
                'dapilDistrictId' => 7,
                'districtId' => 2267,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:05:07',
                'updated_at' => '2023-09-08 06:05:07',
            ),
            36 => 
            array (
                'id' => 37,
                'userId' => 55,
                'dapilDistrictId' => 7,
                'districtId' => 2265,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:05:26',
                'updated_at' => '2023-09-08 06:05:26',
            ),
            37 => 
            array (
                'id' => 38,
                'userId' => 56,
                'dapilDistrictId' => 7,
                'districtId' => 2253,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:05:44',
                'updated_at' => '2023-09-08 06:05:44',
            ),
            38 => 
            array (
                'id' => 39,
                'userId' => 57,
                'dapilDistrictId' => 7,
                'districtId' => 2275,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:06:00',
                'updated_at' => '2023-09-08 06:06:00',
            ),
            39 => 
            array (
                'id' => 40,
                'userId' => 58,
                'dapilDistrictId' => 14,
                'districtId' => 2522,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:06:38',
                'updated_at' => '2023-09-08 06:06:38',
            ),
            40 => 
            array (
                'id' => 41,
                'userId' => 59,
                'dapilDistrictId' => 14,
                'districtId' => 2522,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:06:55',
                'updated_at' => '2023-09-08 06:06:55',
            ),
            41 => 
            array (
                'id' => 42,
                'userId' => 60,
                'dapilDistrictId' => 14,
                'districtId' => 2531,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:07:10',
                'updated_at' => '2023-09-08 06:07:10',
            ),
            42 => 
            array (
                'id' => 43,
                'userId' => 61,
                'dapilDistrictId' => 14,
                'districtId' => 2531,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:07:28',
                'updated_at' => '2023-09-08 06:07:28',
            ),
            43 => 
            array (
                'id' => 44,
                'userId' => 62,
                'dapilDistrictId' => 15,
                'districtId' => 2527,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:07:53',
                'updated_at' => '2023-09-08 06:07:53',
            ),
            44 => 
            array (
                'id' => 45,
                'userId' => 63,
                'dapilDistrictId' => 15,
                'districtId' => 2528,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:08:08',
                'updated_at' => '2023-09-08 06:08:08',
            ),
            45 => 
            array (
                'id' => 46,
                'userId' => 64,
                'dapilDistrictId' => 15,
                'districtId' => 2528,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:08:31',
                'updated_at' => '2023-09-08 06:08:31',
            ),
            46 => 
            array (
                'id' => 47,
                'userId' => 65,
                'dapilDistrictId' => 16,
                'districtId' => 2529,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:08:57',
                'updated_at' => '2023-09-08 06:08:57',
            ),
            47 => 
            array (
                'id' => 48,
                'userId' => 66,
                'dapilDistrictId' => 16,
                'districtId' => 2529,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:09:22',
                'updated_at' => '2023-09-08 06:09:22',
            ),
            48 => 
            array (
                'id' => 49,
                'userId' => 67,
                'dapilDistrictId' => 16,
                'districtId' => 2530,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:09:40',
                'updated_at' => '2023-09-08 06:09:40',
            ),
            49 => 
            array (
                'id' => 50,
                'userId' => 68,
                'dapilDistrictId' => 16,
                'districtId' => 2530,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:09:55',
                'updated_at' => '2023-09-08 06:09:55',
            ),
            50 => 
            array (
                'id' => 51,
                'userId' => 69,
                'dapilDistrictId' => 17,
                'districtId' => 2523,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:10:14',
                'updated_at' => '2023-09-08 06:10:14',
            ),
            51 => 
            array (
                'id' => 52,
                'userId' => 70,
                'dapilDistrictId' => 17,
                'districtId' => 2523,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:10:32',
                'updated_at' => '2023-09-08 06:10:32',
            ),
            52 => 
            array (
                'id' => 53,
                'userId' => 71,
                'dapilDistrictId' => 17,
                'districtId' => 2524,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:10:54',
                'updated_at' => '2023-09-08 06:10:54',
            ),
            53 => 
            array (
                'id' => 54,
                'userId' => 72,
                'dapilDistrictId' => 17,
                'districtId' => 2524,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:11:11',
                'updated_at' => '2023-09-08 06:11:11',
            ),
            54 => 
            array (
                'id' => 55,
                'userId' => 73,
                'dapilDistrictId' => 18,
                'districtId' => 2525,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:11:42',
                'updated_at' => '2023-09-08 06:11:42',
            ),
            55 => 
            array (
                'id' => 56,
                'userId' => 74,
                'dapilDistrictId' => 18,
                'districtId' => 2525,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:12:02',
                'updated_at' => '2023-09-08 06:12:02',
            ),
            56 => 
            array (
                'id' => 57,
                'userId' => 75,
                'dapilDistrictId' => 18,
                'districtId' => 2526,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:12:22',
                'updated_at' => '2023-09-08 06:12:22',
            ),
            57 => 
            array (
                'id' => 58,
                'userId' => 76,
                'dapilDistrictId' => 18,
                'districtId' => 2526,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:12:47',
                'updated_at' => '2023-09-08 06:12:47',
            ),
            58 => 
            array (
                'id' => 59,
                'userId' => 1,
                'dapilDistrictId' => 8,
                'districtId' => 2224,
                'deleted_at' => '2023-09-09 10:55:43',
                'created_at' => '2023-09-08 06:27:26',
                'updated_at' => '2023-09-09 10:55:43',
            ),
            59 => 
            array (
                'id' => 60,
                'userId' => 2,
                'dapilDistrictId' => 8,
                'districtId' => 2225,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:27:44',
                'updated_at' => '2023-09-08 06:27:44',
            ),
            60 => 
            array (
                'id' => 61,
                'userId' => 3,
                'dapilDistrictId' => 8,
                'districtId' => 2227,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:29:53',
                'updated_at' => '2023-09-08 06:29:53',
            ),
            61 => 
            array (
                'id' => 62,
                'userId' => 4,
                'dapilDistrictId' => 8,
                'districtId' => 2245,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:30:09',
                'updated_at' => '2023-09-08 06:31:38',
            ),
            62 => 
            array (
                'id' => 63,
                'userId' => 5,
                'dapilDistrictId' => 9,
                'districtId' => 2229,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:31:57',
                'updated_at' => '2023-09-08 06:31:57',
            ),
            63 => 
            array (
                'id' => 64,
                'userId' => 6,
                'dapilDistrictId' => 9,
                'districtId' => 2230,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:32:16',
                'updated_at' => '2023-09-08 06:32:16',
            ),
            64 => 
            array (
                'id' => 65,
                'userId' => 7,
                'dapilDistrictId' => 9,
                'districtId' => 2231,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:32:57',
                'updated_at' => '2023-09-08 06:32:57',
            ),
            65 => 
            array (
                'id' => 66,
                'userId' => 8,
                'dapilDistrictId' => 9,
                'districtId' => 2231,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:33:14',
                'updated_at' => '2023-09-08 06:33:14',
            ),
            66 => 
            array (
                'id' => 67,
                'userId' => 9,
                'dapilDistrictId' => 9,
                'districtId' => 2247,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:33:28',
                'updated_at' => '2023-09-08 06:33:28',
            ),
            67 => 
            array (
                'id' => 68,
                'userId' => 10,
                'dapilDistrictId' => 9,
                'districtId' => 2247,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:33:44',
                'updated_at' => '2023-09-08 06:33:44',
            ),
            68 => 
            array (
                'id' => 69,
                'userId' => 11,
                'dapilDistrictId' => 10,
                'districtId' => 2232,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:34:27',
                'updated_at' => '2023-09-08 06:34:27',
            ),
            69 => 
            array (
                'id' => 70,
                'userId' => 12,
                'dapilDistrictId' => 10,
                'districtId' => 2233,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:34:44',
                'updated_at' => '2023-09-08 06:34:44',
            ),
            70 => 
            array (
                'id' => 71,
                'userId' => 13,
                'dapilDistrictId' => 10,
                'districtId' => 2234,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:34:59',
                'updated_at' => '2023-09-08 06:34:59',
            ),
            71 => 
            array (
                'id' => 72,
                'userId' => 14,
                'dapilDistrictId' => 10,
                'districtId' => 2248,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:35:15',
                'updated_at' => '2023-09-08 06:35:15',
            ),
            72 => 
            array (
                'id' => 73,
                'userId' => 15,
                'dapilDistrictId' => 10,
                'districtId' => 2235,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:35:31',
                'updated_at' => '2023-09-08 06:35:31',
            ),
            73 => 
            array (
                'id' => 74,
                'userId' => 16,
                'dapilDistrictId' => 11,
                'districtId' => 2236,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:35:47',
                'updated_at' => '2023-09-08 06:35:47',
            ),
            74 => 
            array (
                'id' => 75,
                'userId' => 17,
                'dapilDistrictId' => 11,
                'districtId' => 2237,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:36:03',
                'updated_at' => '2023-09-08 06:36:03',
            ),
            75 => 
            array (
                'id' => 76,
                'userId' => 18,
                'dapilDistrictId' => 11,
                'districtId' => 2238,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:36:19',
                'updated_at' => '2023-09-08 06:36:19',
            ),
            76 => 
            array (
                'id' => 77,
                'userId' => 19,
                'dapilDistrictId' => 11,
                'districtId' => 2239,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:36:46',
                'updated_at' => '2023-09-08 06:36:46',
            ),
            77 => 
            array (
                'id' => 78,
                'userId' => 20,
                'dapilDistrictId' => 11,
                'districtId' => 2244,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:37:04',
                'updated_at' => '2023-09-08 06:37:04',
            ),
            78 => 
            array (
                'id' => 79,
                'userId' => 21,
                'dapilDistrictId' => 12,
                'districtId' => 2240,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:37:32',
                'updated_at' => '2023-09-08 06:37:32',
            ),
            79 => 
            array (
                'id' => 80,
                'userId' => 22,
                'dapilDistrictId' => 12,
                'districtId' => 2241,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:37:46',
                'updated_at' => '2023-09-08 06:37:46',
            ),
            80 => 
            array (
                'id' => 81,
                'userId' => 23,
                'dapilDistrictId' => 12,
                'districtId' => 2249,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:38:02',
                'updated_at' => '2023-09-08 06:38:02',
            ),
            81 => 
            array (
                'id' => 82,
                'userId' => 24,
                'dapilDistrictId' => 12,
                'districtId' => 2250,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:38:18',
                'updated_at' => '2023-09-08 06:38:18',
            ),
            82 => 
            array (
                'id' => 83,
                'userId' => 25,
                'dapilDistrictId' => 13,
                'districtId' => 2226,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:38:38',
                'updated_at' => '2023-09-08 06:38:38',
            ),
            83 => 
            array (
                'id' => 84,
                'userId' => 26,
                'dapilDistrictId' => 13,
                'districtId' => 2228,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:38:54',
                'updated_at' => '2023-09-08 06:38:54',
            ),
            84 => 
            array (
                'id' => 85,
                'userId' => 27,
                'dapilDistrictId' => 13,
                'districtId' => 2242,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:39:10',
                'updated_at' => '2023-09-08 06:39:10',
            ),
            85 => 
            array (
                'id' => 86,
                'userId' => 28,
                'dapilDistrictId' => 13,
                'districtId' => 2243,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:39:27',
                'updated_at' => '2023-09-08 06:39:27',
            ),
            86 => 
            array (
                'id' => 87,
                'userId' => 29,
                'dapilDistrictId' => 13,
                'districtId' => 2246,
                'deleted_at' => NULL,
                'created_at' => '2023-09-08 06:39:43',
                'updated_at' => '2023-09-08 06:39:43',
            ),
            87 => 
            array (
                'id' => 88,
                'userId' => 78,
                'dapilDistrictId' => 3,
                'districtId' => 2262,
                'deleted_at' => NULL,
                'created_at' => '2023-09-09 04:59:58',
                'updated_at' => '2023-09-09 04:59:58',
            ),
            88 => 
            array (
                'id' => 89,
                'userId' => 79,
                'dapilDistrictId' => 12,
                'districtId' => 2250,
                'deleted_at' => NULL,
                'created_at' => '2023-09-09 10:40:16',
                'updated_at' => '2023-09-09 10:40:16',
            ),
            89 => 
            array (
                'id' => 90,
                'userId' => 1,
                'dapilDistrictId' => 8,
                'districtId' => 2224,
                'deleted_at' => NULL,
                'created_at' => '2023-09-09 10:53:20',
                'updated_at' => '2023-09-09 10:53:20',
            ),
            90 => 
            array (
                'id' => 91,
                'userId' => 80,
                'dapilDistrictId' => 2,
                'districtId' => 2251,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}