<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //i already  have all_matches table. i need to get the data of all_matches.

        // then for each of the all_matches i will create 6 questions and add the match_id to the question

        // 1 question =
        //     match_id
        //     Team A to Win
        //     status = 1
        // 2 question =
        //     match_id
        //     Team B to Win
        //     status = 1
        // 2 question =
        //     match_id
        //     Team B to Win
        //     status = 1

        // 3 question =
        //     match_id
        //     Draw
        //     status = 1

        // 4 question =
        //     match_id
        //     Over 2.5 Goals
        //     status = 1
        // 5 question =
        //     match_id
        //     Under 2.5 Goals
        //     status = 1

        // 6 question =
        //     match_id
        //     Both team to score
        //     status = 1



    }
}
