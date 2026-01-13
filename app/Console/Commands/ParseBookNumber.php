<?php

namespace App\Console\Commands;

use App\Models\announce_doc;
use App\Models\costs_doc;
use App\Models\gendoc;
use App\Models\jd_doc;
use App\Models\mou_doc;
use App\Models\project_doc;
use Illuminate\Console\Command;

class ParseBookNumber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parse-book-number {--only=* : Run only specific parsers (ex: wi mou pol)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    protected array $parsers = [
        'mou'    => 'parseMOUBooknum',
        'pol'    => 'parsePOLBooknum',
        'anno'   => 'parseANNOBooknum',
        'proj'   => 'parsePROJBooknum',
        'sop'    => 'parseSOPBooknum',
        'jd'     => 'parseJDBooknum',
        'wi'     => 'parseWIBooknum',
        'md'     => 'parseMDBooknum',
        'course' => 'parseCourseBooknum',
        'check'  => 'parseCheckBooknum',
        'cost'   => 'parseCostBooknum',
    ];
    public function handle()
    {
        $this->info('Starting ParseBookNumber command');

        $only = $this->option('only'); // array

        $parsersToRun = empty($only)
            ? $this->parsers   // ไม่ส่ง option → รันทั้งหมด
            : array_intersect_key($this->parsers, array_flip($only));

        if (empty($parsersToRun)) {
            $this->error('No valid parser selected.');
            return Command::FAILURE;
        }

        $total = count($parsersToRun);
        $step  = 1;

        foreach ($parsersToRun as $key => $method) {
            $this->info("{$step}/{$total} parse{$key}");
            $this->{$method}();
            $step++;
        }

        $this->info('ParseBookNumber command finished');
        return Command::SUCCESS;
    }


    public function parseMOUBooknum() {
        $books = mou_doc::whereNotNull('book_num')->get(['id', 'book_num']);

        try {
            foreach ($books as $book) {
                $old = $book->book_num; // MOU02/2569

                // แยกด้วย /
                [$left, $year] = explode('/', $old);

                // แยก prefix กับตัวเลข
                preg_match('/([A-Z]+)(\d+)/', $left, $matches);
                /*
                    $matches[1] = MOU
                    $matches[2] = 02
                */

                $prefix  = $matches[1];
                $number  = str_pad($matches[2], 2, '0', STR_PAD_LEFT);

                $new = "{$prefix}-ID-{$number}-00-{$year}";

                $book->update([
                    'book_num' => $new
                ]);
            }
            $this->info("parseMOUBooknum updated {$books->count()} records.");
        } catch (\Throwable $th) {
            //throw $th;
            $this->error("Error in parseMOUBooknum: " . $th->getMessage());
        }
    }

    public function parsePOLBooknum() {
        $books = gendoc::where('type', 'policyForm')->get(['id', 'book_num']);

        try {
            foreach ($books as $book) {
                $old = $book->book_num; // POL01/2569

                // แยกด้วย /
                [$left, $year] = explode('/', $old);

                // แยก prefix กับตัวเลข
                preg_match('/([A-Z]+)(\d+)/', $left, $matches);
                /*
                    $matches[1] = POL
                    $matches[2] = 01
                */

                $prefix  = $matches[1];
                $number  = str_pad($matches[2], 2, '0', STR_PAD_LEFT);

                $new = "{$prefix}-ID-{$number}-00-{$year}";

                $book->update([
                    'book_num' => $new
                ]);
            }
            $this->info("parsePOLBooknum updated {$books->count()} records.");
        } catch (\Throwable $th) {
            //throw $th;
            $this->error("Error in parsePOLBooknum: " . $th->getMessage());
        }
    }

    public function parseANNOBooknum() {
        $books = announce_doc::get(['id', 'book_num']);

        try {
            foreach ($books as $book) {
                $old = $book->book_num; // AN01/2569

                // แยกด้วย /
                [$left, $year] = explode('/', $old);

                // แยก prefix กับตัวเลข
                preg_match('/([A-Z]+)(\d+)/', $left, $matches);
                /*
                    $matches[1] = AN
                    $matches[2] = 01
                */

                $prefix  = $matches[1];
                $number  = str_pad($matches[2], 2, '0', STR_PAD_LEFT);

                $new = "{$prefix}-ID-{$number}-00-{$year}";

                $book->update([
                    'book_num' => $new
                ]);
            }
            $this->info("parseANNOBooknum updated {$books->count()} records.");
        } catch (\Throwable $th) {
            //throw $th;
            $this->error("Error in parseANNOBooknum: " . $th->getMessage());
        }
    }

    public function parsePROJBooknum() {
        $books = project_doc::whereNotNull('book_num')->get(['id', 'book_num']);

        try {
            foreach ($books as $book) {
                $old = $book->book_num; // PRO01/2569

                // แยกด้วย /
                [$left, $year] = explode('/', $old);

                // แยก prefix กับตัวเลข
                preg_match('/([A-Z]+)(\d+)/', $left, $matches);
                /*
                    $matches[1] = PRO
                    $matches[2] = 01
                */

                $prefix  = $matches[1];
                $number  = str_pad($matches[2], 2, '0', STR_PAD_LEFT);

                $new = "{$prefix}-ID-{$number}-00-{$year}";

                $book->update([
                    'book_num' => $new
                ]);
            }
            $this->info("parsePROJBooknum updated {$books->count()} records.");
        } catch (\Throwable $th) {
            //throw $th;
            $this->error("Error in parsePROJBooknum: " . $th->getMessage());
        }
    }

    public function parseSOPBooknum() {
        $books = gendoc::where('type', 'sopForm')->get(['id', 'book_num']);

        try {
            foreach ($books as $book) {
                $old = $book->book_num; // SOP01/2569

                // แยกด้วย /
                [$left, $year] = explode('/', $old);

                // แยก prefix กับตัวเลข
                preg_match('/([A-Z]+)(\d+)/', $left, $matches);
                /*
                    $matches[1] = SOP
                    $matches[2] = 01
                */

                $prefix  = $matches[1];
                $number  = str_pad($matches[2], 2, '0', STR_PAD_LEFT);

                $new = "{$prefix}-ID-{$number}-00-{$year}";

                $book->update([
                    'book_num' => $new
                ]);
            }
            $this->info("parseSOPBooknum updated {$books->count()} records.");
        } catch (\Throwable $th) {
            //throw $th;
            $this->error("Error in parseSOPBooknum: " . $th->getMessage());
        }
    }

    public function parseJDBooknum() {
        $books = jd_doc::whereNotNull('book_num')->get(['id', 'book_num']);

        try {
            foreach ($books as $book) {
                $old = $book->book_num; // JD01/2569

                // แยกด้วย /
                [$left, $year] = explode('/', $old);

                // แยก prefix กับตัวเลข
                preg_match('/([A-Z]+)(\d+)/', $left, $matches);
                /*
                    $matches[1] = JD
                    $matches[2] = 01
                */

                $prefix  = $matches[1];
                $number  = str_pad($matches[2], 2, '0', STR_PAD_LEFT);

                $new = "{$prefix}-ID-{$number}-00-{$year}";

                $book->update([
                    'book_num' => $new
                ]);
            }
            $this->info("parseJDBooknum updated {$books->count()} records.");
        } catch (\Throwable $th) {
            //throw $th;
            $this->error("Error in parseJDBooknum: " . $th->getMessage());
        }
    }

    public function parseWIBooknum() {
        $books = gendoc::where('type', 'wiForm')->get(['id', 'book_num', 'created_at']);

        try {
            foreach ($books as $book) {
                $old = $book->book_num; // WI-ID-01

                $year = $book->created_at->year + 543;
                $new  = "{$old}-00-{$year}";

                $book->update([
                    'book_num' => $new
                ]);
            }
            $this->info("parseWIBooknum updated {$books->count()} records.");
        } catch (\Throwable $th) {
            //throw $th;
            $this->error("Error in parseWIBooknum: " . $th->getMessage());
        }
    }

    public function parseMDBooknum() {
        $books = gendoc::where('type', 'LIKE', 'mediaForm%')->get(['id', 'book_num', 'created_at']);

        try {
            foreach ($books as $book) {
                // ดึงเลขท้าย
                preg_match('/(\d+)$/', $book->book_num, $matches);

                if (!isset($matches[1])) {
                    continue;
                }

                $number = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
                $year = $book->created_at->year + 543;

                $new = "BRO-ID-{$number}-00-{$year}";

                $book->update([
                    'book_num' => $new
                ]);
            }
            $this->info("parseMDBooknum updated {$books->count()} records.");
        } catch (\Throwable $th) {
            //throw $th;
            $this->error("Error in parseMDBooknum: " . $th->getMessage());
        }
    }

    public function parseCourseBooknum() {
        $books = gendoc::where('type', 'LIKE', 'courseForm%')->get(['id', 'book_num', 'created_at']);

        try {
            foreach ($books as $book) {
                $old = $book->book_num; // COS-ID-01

                $year = $book->created_at->year + 543;
                $new  = "{$old}-00-{$year}";

                $book->update([
                    'book_num' => $new
                ]);
            }
            $this->info("parseCourseBooknum updated {$books->count()} records.");
        } catch (\Throwable $th) {
            //throw $th;
            $this->error("Error in parseCourseBooknum: " . $th->getMessage());
        }
    }

    public function parseCheckBooknum() {
        $books = gendoc::where('type', 'LIKE', 'checkForm%')->get(['id', 'book_num', 'created_at']);

        try {
            foreach ($books as $book) {
                $old = $book->book_num; // ID-CH-01

                // แยกด้วย -
                [$a, $b, $c] = explode('-', $old);
                // $a = ID, $b = CH, $c = 01
                $number = str_pad($c, 2, '0', STR_PAD_LEFT);

                $year = $book->created_at->year + 543;
                $new = "{$b}-{$a}-{$number}-00-{$year}";

                $book->update([
                    'book_num' => $new
                ]);
            }
            $this->info("parseCheckBooknum updated {$books->count()} records.");
        } catch (\Throwable $th) {
            //throw $th;
            $this->error("Error in parseCheckBooknum: " . $th->getMessage());
        }
    }

    public function parseCostBooknum() {
        $books = costs_doc::whereNotNull('book_num')->get(['id', 'book_num', 'created_at']);

        try {
            foreach ($books as $book) {
                $old = $book->book_num; // ID-CT-01

                // แยกด้วย -
                [$a, $b, $c] = explode('-', $old);
                // $a = ID, $b = CH, $c = 01
                $number = str_pad($c, 2, '0', STR_PAD_LEFT);

                $year = $book->created_at->year + 543;
                $new = "{$b}-{$a}-{$number}-00-{$year}";

                $book->update([
                    'book_num' => $new
                ]);
            }
            $this->info("parseCostBooknum updated {$books->count()} records.");
        } catch (\Throwable $th) {
            //throw $th;
            $this->error("Error in parseCostBooknum: " . $th->getMessage());
        }
    }
}
