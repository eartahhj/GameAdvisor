# GameAdvisor
Game Reviews Portal, open source and based on Laravel 10.

## Website
Go to [GameAdvisor](https://www.gameadvisor.net) and leave a review on some games!

## How to use it
1) [Create a free account](https://www.gameadvisor.net/en/register)
2) Search for a game by browsing the [list of games](https://www.gameadvisor.net/en/games), or by searching by [developer](https://www.gameadvisor.net/en/developers), [publisher](https://www.gameadvisor.net/en/publishers) or [platform](https://www.gameadvisor.net/en/platforms)
3) Choose your game and [start reviewing](https://www.gameadvisor.net/en/games), you can even send anonymous reviews
4) Wait for your review to be approved!

## Why creating an account?
With an account you can access more information and features.
- Guests will not be able to upload images;
- On the other side, verified users will have the opportunity to upload an image together with their review;
- If you sign up with an email that is associated to a Libravatar, this will be used in the website, so it is easier for you and will save some space on the server

## Anonymous reviews
You can write an anonymous review: it will really be anonymous, since it will not be associated to your account, even if you are logged in!
On the other hand of course, since those reviews are not linked to any account, you will not be able to find the anonymous reviews you have posted in the past.

## Privacy
We do our best to protect your privacy, but please be aware that, of course, your IP will appear in our server logs.
The server is in the EU and the database is on the same server.
We use Matomo on-premise as a tracking service, and the data is stored on a separate database, but it is still on the same server.

## Accessibility
GameAdvisor tries to be as much accessible as possible. If you find errors or want to send some improvements, please send us an email or open an issue on Github.

## Upcoming features
There are a few features that we plan on introducing, but will require some time:
- Improving search features and filters
- Improving the collection of data (games, platforms, developers, etc.)
- Allowing games to be associated to multiple platforms
- Creating free APIs to request some data like games, platforms, developers, publishers. Not sure about reviews yet.
- Adding paid plans to unlock some more features for subscribers. For example, being able to add more than one image, or having your reviews highlighted, being able to put links in your reviews, and so on
- Allowing users to signup/login with Steam and eventually other platforms
- Allowing users to share their reviews on Steam and eventually other platforms (if possible)

## Contributing
You can contribute by just making a small [donation](https://www.gameadvisor.net/en/pages/2-donations), we appreciate it!

On the other hand, we need some help translating and testing!

## Translations
The translations are made with Gettext for PHP.
English and Italian are pretty much covered, but if you want to add your language you can just download the POT file, open it with Poedit or with a text editor for translating in your own language. You will need to create a PO file and then compile them into MO files. Poedit can compile them into PO, otherwise you will need to install and configure gettext and msgfmt in your system.

If you are translating for your own project, that's fine.

Otherwise, if you would like GameAdvisor to provide a new language, please contact us before or just open a discussion on Github.

## Tests
Aside from donations, we would need some help on testing the features.
- Verifying that images are correctly deleted when an entity is destroyed
- Verifying that images are updated correctly when updating entities, and that the old images are deleted
- Verifying that guests cannot post images
- Verifying that routes are working properly with their middlewares, for example that a guest cannot delete an admin
- Check that emails and notifications are working as intended
- Check that guests cannot see the emails of a user on a review

## License
You can use this project as you like under the GNU GPL v3 License.
We would appreciate an attribution, with a backlink to our website or to this Github repository in your footer or credits page.

## About Laravel
Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.
