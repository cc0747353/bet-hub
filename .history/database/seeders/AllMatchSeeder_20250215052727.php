<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AllMatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $leagues = [
            '9e36e694-365c-48eb-b203-c815c03d0bb5' => [
                'Arsenal', 'Aston Villa', 'Bournemouth', 'Brentford', 'Brighton & Hove Albion', 'Burnley', 'Chelsea', 'Crystal Palace', 'Everton', 'Fulham', 'Liverpool', 'Luton Town', 'Manchester City', 'Manchester United', 'Newcastle United', 'Nottingham Forest', 'Sheffield United', 'Tottenham Hotspur', 'West Ham United', 'Wolverhampton Wanderers'
            ],
            '9e36e694-4682-4f6d-8535-c352af6adecc' => [
                'Barnsley', 'Birmingham City', 'Blackpool', 'Bolton Wanderers', 'Bristol Rovers', 'Burton Albion', 'Cambridge United', 'Charlton Athletic', 'Cheltenham Town', 'Crawley Town', 'Exeter City', 'Fleetwood Town', 'Forest Hill Park', 'Huddersfield Town', 'Leyton Orient', 'Lincoln City', 'Mansfield Town', 'Northampton Town', 'Oxford United', 'Peterborough United', 'Port Vale', 'Reading', 'Rotherham United', 'Shrewsbury Town', 'Stevenage', 'Stockport County', 'Wigan Athletic', 'Wrexham', 'Wycombe Wanderers'
            ],
            '9e36e694-47be-45ea-801b-a236e5cd0f12' => [
                'Alfreton Town', 'Banbury United', 'Blyth Spartans', 'Boston United', 'Brackley Town', 'Buxton', 'Curzon Ashton', 'Darlington', 'Farsley Celtic', 'Gloucester City', 'Hereford', 'King\'s Lynn Town', 'Leamington', 'Peterborough Sports', 'Rushall Olympic', 'Scarborough Athletic', 'Southport', 'Spennymoor Town', 'Tamworth', 'Telford United'
            ],
            '9e36e694-49c9-4137-a3b3-1d880b4b97f4' => [
                'Aldershot Town', 'Altrincham', 'Barnet', 'Braintree Town', 'Bromley', 'Dagenham & Redbridge', 'Eastleigh', 'FC Halifax Town', 'Forest Green Rovers', 'Gateshead', 'Hartlepool United', 'Maidenhead United', 'Oldham Athletic', 'Rochdale', 'Solihull Moors', 'Southend United', 'Sutton United', 'Tamworth', 'Woking', 'Yeovil Town', 'York City'
            ],
            '9e36e694-4af9-4267-8654-18fa42300bf6' => [
                'Accrington Stanley', 'AFC Wimbledon', 'Barrow', 'Bradford City', 'Bromley', 'Carlisle United', 'Colchester United', 'Crewe Alexandra', 'Doncaster Rovers', 'Gillingham', 'Grimsby Town', 'Harrogate Town', 'MK Dons', 'Morecambe', 'Newport County', 'Notts County', 'Port Vale', 'Salford City', 'Swindon Town', 'Tranmere Rovers', 'Walsall'
            ],
        ];

        foreach ($leagues as $leagueId => $teams) {
            for ($i = 0; $i < 20; $i++) {
                shuffle($teams);
                $teamA = $teams[0];
                $teamB = $teams[1];

                DB::table('all_matches')->insert([
                    'id' => Str::uuid(),
                    'match_title' => "$teamA - $teamB",
                    'league_id' => $leagueId,
                    'team_a' => $teamA,
                    'team_b' => $teamB,
                    'match_start' => Carbon::now()->addMinutes(30),
                    'start_from' => Carbon::now()->subHours(24),
                    'end_at' => Carbon::now()->addMinutes(130),
                    'status' => 1,
                    'is_locked' => false,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
