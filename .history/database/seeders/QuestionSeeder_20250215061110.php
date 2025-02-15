<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Fetch all matches from the all_matches table
        $matches = DB::table('all_matches')->get();

        // Define the questions to be created for each match
        $questions = [
            'Team A to Win',
            'Team B to Win',
            'Draw',
            'Over 2.5 Goals',
            'Under 2.5 Goals',
            'Both team to score'
        ];

        // Loop through each match and create questions
        foreach ($matches as $match) {
            foreach ($questions as $question) {
                DB::table('questions')->insert([
                    'match_id' => $match->id,
                    'question' => $question,
                    'status' => 1, // Active status
                ]);
            }
        }
    }
}
