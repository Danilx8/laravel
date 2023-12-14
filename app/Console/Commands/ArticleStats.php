<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Path;
use App\Models\Comment;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Mail\ArticleMailStats;

class ArticleStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'article-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $articleCount = Path::all()->count();
        $commentCount = Comment::whereDate('created_at', Carbon::today())->count();
        Log::alert(Carbon::now());

        Path::whereNotNull('id')->delete();
        Mail::to('lugovskihdanil@yandex.ru')->send(new ArticleMailStats($articleCount, $commentCount));
        return 0;
    }
}
