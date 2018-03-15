# Zona

[![Join the chat at https://gitter.im/zona/Lobby](https://badges.gitter.im/zona/Lobby.svg)](https://gitter.im/zona/Lobby?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bantenprov/zona/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bantenprov/zona/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/bantenprov/zona/badges/build.png?b=master)](https://scrutinizer-ci.com/g/bantenprov/zona/build-status/master)
[![Latest Stable Version](https://poser.pugx.org/bantenprov/zona/v/stable)](https://packagist.org/packages/bantenprov/zona)
[![Total Downloads](https://poser.pugx.org/bantenprov/zona/downloads)](https://packagist.org/packages/bantenprov/zona)
[![Latest Unstable Version](https://poser.pugx.org/bantenprov/zona/v/unstable)](https://packagist.org/packages/bantenprov/zona)
[![License](https://poser.pugx.org/bantenprov/zona/license)](https://packagist.org/packages/bantenprov/zona)
[![Monthly Downloads](https://poser.pugx.org/bantenprov/zona/d/monthly)](https://packagist.org/packages/bantenprov/zona)
[![Daily Downloads](https://poser.pugx.org/bantenprov/zona/d/daily)](https://packagist.org/packages/bantenprov/zona)


# Zona
Zona

### Install via composer

- Development snapshot

```bash
$ composer require bantenprov/zona:dev-master
```

- Latest release:

### Download via github

```bash
$ git clone https://github.com/bantenprov/zona.git
```

#### Edit `config/app.php` :

```php
'providers' => [

    /*
    * Laravel Framework Service Providers...
    */
    Illuminate\Auth\AuthServiceProvider::class,
    Illuminate\Broadcasting\BroadcastServiceProvider::class,
    Illuminate\Bus\BusServiceProvider::class,
    Illuminate\Cache\CacheServiceProvider::class,
    Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
    Illuminate\Cookie\CookieServiceProvider::class,
    //....
    Bantenprov\Zona\ZonaServiceProvider::class,
```

#### Lakukan migrate :

```bash
$ php artisan migrate
```

#### Publish database seeder :

```bash
$ php artisan vendor:publish --tag=zona-seeds

```

#### Lakukan auto dump :

```bash
$ composer dump-autoload
```

#### Lakukan seeding :

```bash
$ php artisan db:seed --class=BantenprovZonaSeeder
```

#### Lakukan publish component vue :

```bash
$ php artisan vendor:publish --tag=zona-assets
$ php artisan vendor:publish --tag=zona-public
```
#### Tambahkan route di dalam file : `resources/assets/js/routes.js` :

```javascript
{
    path: '/dashboard',
    redirect: '/dashboard/home',
    component: layout('Default'),
    children: [
        //== ...
       {
        path: '/dashboard/zona',
        components: {
            main: resolve => require(['./components/views/bantenprov/zona/DashboardZona.vue'], resolve),
            navbar: resolve => require(['./components/Navbar.vue'], resolve),
            sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
        },
        meta: {
            title: "Zona"
        }
      }
        //== ...
    ]
},
```

```javascript
{
    path: '/admin',
    redirect: '/admin/dashboard/home',
    component: layout('Default'),
    children: [
        //== ...
        {
            path: '/admin/zona',
            components: {
                main: resolve => require(['./components/bantenprov/zona/Zona.index.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Zona"
            }
        },
        {
            path: '/admin/zona/create',
            components: {
                main: resolve => require(['./components/bantenprov/zona/Zona.add.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Zona"
            }
        },
        {
            path: '/admin/zona/:id',
            components: {
                main: resolve => require(['./components/bantenprov/zona/Zona.show.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Zona"
            }
        },
        {
            path: '/admin/zona/:id/edit',
            components: {
                main: resolve => require(['./components/bantenprov/zona/Zona.edit.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Zona"
            }
        },
        //== ...
    ]
},
```
#### Edit menu `resources/assets/js/menu.js`

```javascript
{
    name: 'Dashboard',
    icon: 'fa fa-dashboard',
    childType: 'collapse',
    childItem: [
        //== ...
        {
          name: 'Zona',
          link: '/dashboard/zona',
          icon: 'fa fa-angle-double-right'
      }
        //== ...
    ]
},
```

```javascript
{
    name: 'Admin',
    icon: 'fa fa-lock',
    childType: 'collapse',
    childItem: [
        //== ...
        {
            name: 'Zona',
            link: '/admin/zona',
            icon: 'fa fa-angle-double-right'
          }
        //== ...
    ]
},
```

#### Tambahkan components `resources/assets/js/components.js` :

```javascript

//== Example Vuetable

import Zona from './components/bantenprov/zona/Zona.chart.vue';
Vue.component('echarts-zona', Zona);

import ZonaKota from './components/bantenprov/zona/ZonaKota.chart.vue';
Vue.component('echarts-dpp-bank-dinia-kota', ZonaKota);

import ZonaTahun from './components/bantenprov/zona/ZonaTahun.chart.vue';
Vue.component('echarts-dpp-bank-dinia-tahun', ZonaTahun);

import ZonaAdminShow from './components/bantenprov/zona/ZonaAdmin.show.vue';
Vue.component('admin-view-zona-tahun', ZonaAdminShow);

//== Echarts Zona

import ZonaBar01 from './components/views/bantenprov/zona/ZonaBar01.vue';
Vue.component('zona-bar-01', ZonaBar01);

import ZonaBar02 from './components/views/bantenprov/zona/ZonaBar02.vue';
Vue.component('zona-bar-02', ZonaBar02);

//== mini bar charts
import ZonaBar03 from './components/views/bantenprov/zona/ZonaBar03.vue';
Vue.component('zona-bar-03', ZonaBar03);

import ZonaPie01 from './components/views/bantenprov/zona/ZonaPie01.vue';
Vue.component('zona-pie-01', ZonaPie01);

import ZonaPie02 from './components/views/bantenprov/zona/ZonaPie02.vue';
Vue.component('zona-pie-02', ZonaPie02);

//== mini pie charts
import ZonaPie03 from './components/views/bantenprov/zona/ZonaPie03.vue';
Vue.component('zona-pie-03', ZonaPie03);
