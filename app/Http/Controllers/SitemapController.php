<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function generateSitemap()
    {
        $sitemap = Sitemap::create()  // Use Sitemap::create(), not SitemapGenerator
        ->add(Url::create('/')->setPriority(1.0)->setChangeFrequency('daily'))
            ->add(Url::create('/about-us')->setPriority(0.8)->setChangeFrequency('weekly'))
            ->add(Url::create('/contact-us')->setPriority(0.7)->setChangeFrequency('monthly'))
            ->add(Url::create('/career-guidance/employment/employment-policy')->setPriority(0.6)->setChangeFrequency('monthly'))
            ->add(Url::create('/career-guidance/employment/newsletter')->setPriority(0.5)->setChangeFrequency('monthly'))
            ->add(Url::create('/career-guidance/career-information/job-information')->setPriority(0.4)->setChangeFrequency('monthly'))
            ->add(Url::create('/career-guidance/career-information/career-expert-interview')->setPriority(0.3)->setChangeFrequency('monthly'))
            ->add(Url::create('/public-event')->setPriority(0.2)->setChangeFrequency('monthly'))
            ->add(Url::create('/informations/qnas')->setPriority(0.1)->setChangeFrequency('monthly'))
            ->add(Url::create('/notices?#notice')->setPriority(0.0)->setChangeFrequency('monthly'));

        // Write the sitemap to public/sitemap.xml
        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}
