{{ sprintf(_('New review has been posted on %s'), env('APP_NAME')) . "\n\n"}}
{{"ID: {$review->id}\nTitle: {$review->title}\nGame ID: {$review->game_id}"}}
