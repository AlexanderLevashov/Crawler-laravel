<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;

class parseCorespondent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:corespondent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $html = file_get_contents('https://www.imdb.com/title/tt1270797/?ref_=fn_al_tt_1');
        $crawler = new Crawler($html);
        $title = $crawler->filter('h1')->text();
        $rating = $crawler->filter('#title-overview-widget > div.vital > div.title_block > div > div.ratings_wrapper > div.imdbRating > div.ratingValue > strong > span')->text();
        $plot = $crawler->filter('#title-overview-widget > div.plot_summary_wrapper > div.plot_summary > div.summary_text')->text();
        $keywords = $crawler->filter('#titleStoryLine > div:nth-child(6) > a')->each(function (Crawler $node, $i) {
            return $node->text();
        });
        $link = $crawler->filter('#title-overview-widget > div.plot_summary_wrapper > div.titleReviewBar > div:nth-child(1) > div > div:nth-child(2) > span > a');
        $source = $link->attr('href');

        print_r([
            $title,
            $rating,
            $plot,
            $keywords,
            $source
        ]);


    }
}
