<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\League;

class LeagueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //  leagues data
        // 1. Premier League
        // 2. League One
        // 3. National League North
        // 4. National League
        // 5. League Two
        // 6. Isthmian League
        // 7. Northern Premier League
        // 8. Championship
        // 9. Northern League
        // 10. NFL (National Football League)
        // 11. CFL (Canadian Football League)
        // 12. American Football League
        // 13. American Football Conference
        // 14. North Louisiana Football League
        // 15. Professional Developmental Football League
        // 16. United States Football League
        // 17. College Football
        // 18. Rivals Professional Football League
        // 19. XFL
        // 20. National Women's Football Association
        // 21. National Football Conference
        // 22. USL Championship
        // 23. Empire Football League
        // 24. USA Football
        // 25. Gridiron Developmental League
        // 26. Pacific Pro Football
        // 27. Freedom Football League
        // 28. International Federation of American Football
        // 29. Indoor Football League
        // 30. MLS (Major League Soccer)
        // 31. USL League Two
        // 32. Florida Football Alliance
        // 33. NBA (National Basketball Association)
        // 34. North American Football League
        // 35. The Spring League
        // 36. Major League Football
        // 37. NCAA Division I Football Subdivision (FBS)
        // 38. DC Gay Flag Football League (DCGFL)
        // 39. Hawaii Professional Football League (HPFL)
        // 40. National Independent Soccer Association (NISA)
        // 41. Arena Football League (AFL)
        // 42. Pacific Coast Professional Football League (PCFL)
        // 43. All American Football League (AAFL)
        // 44. X-League (This appears twice, but I've only listed it once in the combined list)
        // 45. U.S. Soccer
        // 46. International Football Alliance
        // 47. National Premier Soccer League (NPSL)
        // 48. National Women's Soccer League (NWSL)
        // 49. NCAA Division I Football Championship Subdivision (FCS)
        // 50. Eastern Football Netball Association
        // 51. Tokai Collegiate American Football League
        // 52. Australian Gridiron League
        // 53. American 7's Football League (A7FL)
        // 54. International Football Federation
        // 55. USL League One (USL1)
        // 56. NWSL Fall Series
        // 57. New England Football League (NEFL)
        // 58. Spring Football League (This appears twice, but I've only listed it once in the combined list)
        // 59. Elite Football League of Texas
        // 60. Hokuriku Collegiate American Football League (HCAFL)

        // LEAGUES TABLE STRUCTURE
        // Schema::create('leagues', function (Blueprint $table) {
        //     $table->uuid('id')->primary();
        //     $table->uuid('category_id')->nullable();
        //     $table->string('name');
        //     $table->string('icon');
        //     $table->string('status');

        //     $table->foreign('category_id')
        //         ->references('id')
        //         ->on('categories')
        //         ->onUpdate('cascade');
        //     $table->timestamps();
        // });


        // CREATE LEAGUSES DATA ARRAY and dont add the id field ust name and icon where name is all caps and icon is the name in lowercase

        $leagues = [
            [
                'name' => 'Premier League',
                'icon' => 'premier-league',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'League One',
                'icon' => 'league-one',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'National League North',
                'icon' => 'national-league-north',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'National League',
                'icon' => 'national-league',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'League Two',
                'icon' => 'league-two',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'Isthmian League',
                'icon' => 'isthmian-league',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'Northern Premier League',
                'icon' => 'northern-premier-league',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'Championship',
                'icon' => 'championship',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'Northern League',
                'icon' => 'northern-league',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'NFL',
                'icon' => 'nfl',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'CFL',
                'icon' => 'cfl',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'American Football League',
                'icon' => 'american-football-league',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'American Football Conference',
                'icon' => 'american-football-conference',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'North Louisiana Football League',
                'icon' => 'north-louisiana-football-league',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'Professional Developmental Football League',
                'icon' => 'professional-developmental-football-league',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'United States Football League',
                'icon' => 'united-states-football-league',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'College Football',
                'icon' => 'college-football',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'Rivals Professional Football League',
                'icon' => 'rivals-professional-football-league',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'XFL',
                'icon' => 'xfl',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'National Women\'s Football Association',
                'icon' => 'national-womens-football-association',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'National Football Conference',
                'icon' => 'national-football-conference',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'USL Championship',
                'icon' => 'usl-championship',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'Empire Football League',
                'icon' => 'empire-football-league',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'USA Football',
                'icon' => 'usa-football',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'Gridiron Developmental League',
                'icon' => 'gridiron-developmental-league',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'Pacific Pro Football',
                'icon' => 'pacific-pro-football',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'Freedom Football League',
                'icon' => 'freedom-football-league',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'International Federation of American Football',
                'icon' => 'international-federation-of-american-football',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'Indoor Football League',
                'icon' => 'indoor-football-league',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'MLS',
                'icon' => 'mls',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'USL League Two',
                'icon' => 'usl-league-two',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'Florida Football Alliance',
                'icon' => 'florida-football-alliance',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'NBA',
                'icon' => 'nba',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'North American Football League',
                'icon' => 'north-american-football-league',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'The Spring League',
                'icon' => 'the-spring-league',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'Major League Football',
                'icon' => 'major-league-football',
                'status' => League::ACTIVE
            ],
            [
                'name' => 'NCAA Division I Football Subdivision',
                'icon' => 'ncaa-division-i-football-subdivision',
                'status' => League::ACTIVE
            ],

        ];

        // INSERT LEAGUES DATA and specify category_id
        foreach ($leagues as $league) {

            League::create([
                'category_id' => '9e36dfad-d88b-4da1-b523-b67a74f819cf',
                'name' => $league['name'],
                'icon' => $league['icon'],
                'status' => $league['status']
            ]);
        }

    }
}
