<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('article_tags')->delete();
        $this->call('ArticleTableSeeder');
        $this->command->info('Article table seeded!');
        $this->call('TagTableSeeder');
        $this->command->info('Tag table seeded!');
        $this->call('ArticleTagTableSeeder');
        $this->command->info('ArticleTag table seeded!');
    }
}
