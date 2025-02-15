<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContactUsRequest;
use App\Http\Requests\CreateSubscriberRequest;
use App\Models\AllMatch;
use App\Models\BetWin;
use App\Models\Blog;
use App\Models\Category;
use App\Models\ContactUs;
use App\Models\DepositTransaction;
use App\Models\FAQs;
use App\Models\FrontSetting;
use App\Models\League;
use App\Models\Partner;
use App\Models\ReferralLevel;
use App\Models\Subscriber;
use App\Models\User;
use App\Models\WithdrawRequests;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LandingPageController extends AppBaseController
{
    public function index(): Factory|View|Application
    {
        $categoryData = Category::with(['league.match.questions.options'])->whereStatus(1)->get();
        $homePageData = FrontSetting::pluck('value', 'key')->toArray();
        $homeBgImages = FrontSetting::where('key', '=', 'home_bg_image')->first()->image_url;
        $partners = Partner::all();
        $totalBalance = getTotalBalance();

        return view('front.index', compact('categoryData', 'homePageData', 'partners', 'totalBalance','homeBgImages'));
    }

    public function contact(): Factory|View|Application
    {
        $contactUsData = FrontSetting::pluck('value', 'key')->toArray();

        return view('front.contact-us', compact('contactUsData'));
    }

    public function contactUsStore(CreateContactUsRequest $request): JsonResponse
    {
        $input = $request->all();
        ContactUs::create($input);

        return $this->sendSuccess(__('messages.flash.message_sent'));
    }

    public function about(): Factory|View|Application
    {
        $data = [];
        $aboutUsData = FrontSetting::pluck('value', 'key')->toArray();
        $faqData = FAQs::where('status', FAQs::ACTIVE)->get();
        $data['usersCount'] = User::whereHas('roles', function ($q) {
            $q->where('name', 'member');
        })->count();
        $data['matchesCount'] = AllMatch::count();
        $data['transactionsCount'] = DepositTransaction::count() + WithdrawRequests::count();
        $data['betWins'] = BetWin::count();

        return view('front.about-us', compact('aboutUsData', 'faqData', 'data'));
    }

    public function affiliate(): Factory|View|Application
    {
        $latestBlogs = Blog::latest('created_at')->take(3)->get();
        $referralLevels = ReferralLevel::take(3)->get();
        $affiliate = FrontSetting::pluck('value', 'key')->toArray();
        return view('front.affiliate', compact('latestBlogs', 'referralLevels', 'affiliate'));
    }

    public function blogs(): Factory|View|Application
    {
        $blogs = Blog::latest('created_at')->get();

        return view('front.blogs', compact('blogs'));
    }

    public function blogDetails($slug): Factory|View|Application
    {
        $blog = Blog::whereSlug($slug)->first();
        $recentBlogs = Blog::whereNot('slug', $slug)->latest('created_at')->take(3)->get();

        return view('front.blog-details', compact('blog', 'recentBlogs'));
    }

    public function licencesInfoDetails(): Application|Factory|View|RedirectResponse
    {
        $licencesInfo = FrontSetting::where('key', 'licences_info')->pluck('value', 'key')->toArray();

        return view('front.licences_info_details', compact('licencesInfo'));
    }

    public function rulesForBetDetails(): Application|Factory|View|RedirectResponse
    {
        $ruleForBet = FrontSetting::where('key', 'rules_for_bet')->pluck('value', 'key')->toArray();

        return view('front.rules_for_bet_details', compact('ruleForBet'));
    }

    public function termsOfServiceDetails(): Application|Factory|View|RedirectResponse
    {
        $termsOfService = FrontSetting::where('key', 'terms_of_service')->pluck('value', 'key')->toArray();

        return view('front.terms_of_service_details', compact('termsOfService'));
    }

    public function privacyPolicyDetails(): Application|Factory|View|RedirectResponse
    {
        $privacyPolicy = FrontSetting::where('key', 'privacy_policy')->pluck('value', 'key')->toArray();

        return view('front.privacy_policy_details', compact('privacyPolicy'));
    }

    public function matchDetails($id): Factory|View|Application
    {
        $matchDetails = AllMatch::with('league', 'questions.options')->whereId($id)->first();

        return view('front.match-details', compact('matchDetails'));
    }

    public function saveSubscribeUser(CreateSubscriberRequest $request): JsonResponse
    {
        Subscriber::create($request->all());

        return $this->sendSuccess(__('messages.flash.subscribed'));
    }

    /**
     * @param Request $request
     * @param $category_id
     *
     *
     * @return Application|Factory|View
     */
    public function matchListByCategory(Request $request, $category_id)
    {
        $type = $request['type'];
        $categoryData = Category::whereId($category_id)->get();
        $homePageData = FrontSetting::pluck('value', 'key')->toArray();
        $homeBgImages = FrontSetting::where('key', '=', 'home_bg_image')->first()->image_url;
        return view('front.match-list-by-category', compact('category_id','type', 'categoryData', 'homePageData', 'homeBgImages'));
    }

    /**
     * @param Request $request
     * @param $league_id
     *
     *
     * @return Application|Factory|View
     */
    public function matchListByLeague(Request $request, $league_id)
    {
        $type = $request['type'];
        $leagueData = League::with(['category'])->whereId($league_id)->get();
        if ($type == 'live') {
            $matches = AllMatch::whereDate('match_start', Carbon::today())->whereLeagueId($league_id)->get();
        } elseif ($type == 'upcoming') {
            $matches = AllMatch::whereDate('match_start', '>=', Carbon::tomorrow())->whereLeagueId($league_id)->get();
        }
        $homePageData = FrontSetting::pluck('value', 'key')->toArray();
        $homeBgImages = FrontSetting::where('key', '=', 'home_bg_image')->first()->image_url;

        return view('front.match-list-by-league', compact('league_id', 'type', 'leagueData', 'matches', 'homePageData', 'homeBgImages'));
    }
}
