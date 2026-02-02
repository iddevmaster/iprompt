<?php

namespace App\Console\Commands;

use App\Models\gendoc;
use Illuminate\Console\Command;

class ChangeBookNumber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:change-book-number';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->changeSOPBookNum();
        $this->changeMediaBookNum();
    }

    public function changeSOPBookNum() {
        try {
            $sop_books = gendoc::where('type', 'sopForm')->get(['id', 'book_num']);
            foreach ($sop_books as $book) {
                $old_book_num = $book->book_num;
                $new_book_num = str_replace('SOP-', 'WF-', $old_book_num);
                $book->book_num = $new_book_num;
                $book->save();
                $this->info("Changed book number from {$old_book_num} to {$new_book_num}");
            }
            $this->info("========== Changed book number successfully!! ==========");
        } catch (\Throwable $th) {
            //throw $th;
            $this->error("Sop Error occurred: " . $th->getMessage());
        }
    }

    public function changeMediaBookNum() {
        try {
            $sop_books = gendoc::where('type', 'LIKE', 'mediaForm%')->get(['id', 'book_num']);
            foreach ($sop_books as $book) {
                $old_book_num = $book->book_num;
                $new_book_num = str_replace('BRO-', 'MEDIA-', $old_book_num);
                $book->book_num = $new_book_num;
                $book->save();
                $this->info("Changed book number from {$old_book_num} to {$new_book_num}");
            }
            $this->info("========== Changed book number successfully!! ==========");
        } catch (\Throwable $th) {
            //throw $th;
            $this->error("Media Error occurred: " . $th->getMessage());
        }
    }
}
