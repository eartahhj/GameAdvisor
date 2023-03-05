{{ sprintf(_('New user has registered on %s'), env('APP_NAME')) . "\n\n"}}
{{"ID: {$user->id}\nEmail: {$user->email}\nUsername: {$user->name}"}}
