<?php

namespace App\Providers;

use App\General\BuildBaseMenu;
use App\Models\Website\MenuPage;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class MenuServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @param \Illuminate\Contracts\Events\Dispatcher $events
     */
    public function boot(Dispatcher $events)
    {
        $this->displayBaseMenu($events);

        $this->displayDynamicMenu($events);
        //$this->displaySubMenus($events);
    }

    /**
     * Display the base menu.
     *
     * @param \Illuminate\Contracts\Events\Dispatcher $events
     */
    protected function displayBaseMenu(Dispatcher $events)
    {
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->add('BASE MENU');
            $event->menu->add(... BuildBaseMenu::build());
        });
    }

    /**
     * Display the dynamically created, database-driven menu.
     *
     * @param \Illuminate\Contracts\Events\Dispatcher $events
     */
    protected function displayDynamicMenu(Dispatcher $events)
    {
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            MenuPage::all()->map(function (MenuPage $page) use ($event) {
                if ($page['isTitle']) {
                    $event->menu->add([
                        'header' => strtoupper($page['text']),
                        'can'    => $page['can'],
                    ]);
                }

                if (! $page['isTitle']) {
                    $item = [
                        'id'     => 10 . $page['id'],
                        'text'   => $page['text'],
                        'route'  => $page['route'],
                        'url'    => $page['url'],
                        'target' => $page['target'],
                        'icon'   => $page['icon'],
                        'can'    => $page['can'],
                    ];

                    $event->menu->add($item);
                }
            });
        });
    }

    /**
     * Display sub-menus.
     *
     * @param \Illuminate\Contracts\Events\Dispatcher $events
     * @param                                         $page
     */
    protected function displaySubMenus(Dispatcher $events, $page)
    {
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->add([
                [
                    'header' => $page['text'],
                ],
                'text'    => 'Sub menu 1',
                'submenu' => [
                    'text' => 'I go moo...',
                    'url'  => '#moo',
                ],
            ]);
        });
    }
}
