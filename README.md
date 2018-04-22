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

Zona

### Install via composer

- Development snapshot

```bash
$ composer require bantenprov/zona:dev-master
```

- Latest release:

```bash
$ composer require bantenprov/zona
```

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
    //...
    Bantenprov\Zona\ZonaServiceProvider::class,
    //...
```

#### Lakukan migrate :

```bash
$ php artisan migrate
```

#### Lakukan publish semua komponen :

```bash
$ php artisan vendor:publish --tag=zona-publish
```

#### Lakukan auto dump :

```bash
$ composer dump-autoload
```

#### Lakukan seeding :

```bash
$ php artisan db:seed --class=BantenprovZonaSeeder
```

#### Edit menu `resources/assets/js/menu.js`

```javascript
{
    name: 'Dashboard',
    icon: 'fa fa-dashboard',
    childType: 'collapse',
    childItem: [
        //...
        // Master Zona
        {
            name: 'Master Zona',
            link: '/dashboard/master-zona',
            icon: 'fa fa-angle-double-right'
        },
        // Zona
        {
            name: 'Zona',
            link: '/dashboard/zona',
            icon: 'fa fa-angle-double-right'
        },
        //...
    ]
},
```

```javascript
{
    name: 'Admin',
    icon: 'fa fa-lock',
    childType: 'collapse',
    childItem: [
        //...
        // Master Zona
        {
            name: 'Master Zona',
            link: '/admin/master-zona',
            icon: 'fa fa-angle-double-right'
        },
        // Zona
        {
            name: 'Zona',
            link: '/admin/zona',
            icon: 'fa fa-angle-double-right'
        },
        //...
    ]
},
```

#### Tambahkan components `resources/assets/js/components.js` :

```javascript
//... Zona ...//

import ZonaAdminShow from '~/components/bantenprov/zona/zona/ZonaAdmin.show.vue';
Vue.component('zona-admin', ZonaAdminShow);

//... Echarts Zona ...//

import Zona from '~/components/bantenprov/zona/zona/Zona.chart.vue';
Vue.component('zona-echarts', Zona);

import ZonaKota from '~/components/bantenprov/zona/zona/ZonaKota.chart.vue';
Vue.component('zona-echarts-kota', ZonaKota);

import ZonaTahun from '~/components/bantenprov/zona/zona/ZonaTahun.chart.vue';
Vue.component('zona-echarts-tahun', ZonaTahun);

//... Mini Bar Charts Zona ...//

import ZonaBar01 from '~/components/views/bantenprov/zona/zona/ZonaBar01.vue';
Vue.component('zona-bar-01', ZonaBar01);

import ZonaBar02 from '~/components/views/bantenprov/zona/zona/ZonaBar02.vue';
Vue.component('zona-bar-02', ZonaBar02);

import ZonaBar03 from '~/components/views/bantenprov/zona/zona/ZonaBar03.vue';
Vue.component('zona-bar-03', ZonaBar03);

//... Mini Pie Charts Zona ...//

import ZonaPie01 from '~/components/views/bantenprov/zona/zona/ZonaPie01.vue';
Vue.component('zona-pie-01', ZonaPie01);

import ZonaPie02 from '~/components/views/bantenprov/zona/zona/ZonaPie02.vue';
Vue.component('zona-pie-02', ZonaPie02);

import ZonaPie03 from '~/components/views/bantenprov/zona/zona/ZonaPie03.vue';
Vue.component('zona-pie-03', ZonaPie03);

//... Master Zona ...//

import MasterZonaAdminShow from '~/components/bantenprov/zona/master-zona/MasterZonaAdmin.show.vue';
Vue.component('master-zona-admin', MasterZonaAdminShow);

//... Echarts Master Zona ...//

import MasterZona from '~/components/bantenprov/zona/master-zona/MasterZona.chart.vue';
Vue.component('master-zona-echarts', MasterZona);

import MasterZonaKota from '~/components/bantenprov/zona/master-zona/MasterZonaKota.chart.vue';
Vue.component('master-zona-echarts-kota', MasterZonaKota);

import MasterZonaTahun from '~/components/bantenprov/zona/master-zona/MasterZonaTahun.chart.vue';
Vue.component('master-zona-echarts-tahun', MasterZonaTahun);

//... Mini Bar Charts Master Zona ...//

import MasterZonaBar01 from '~/components/views/bantenprov/zona/master-zona/MasterZonaBar01.vue';
Vue.component('master-zona-bar-01', MasterZonaBar01);

import MasterZonaBar02 from '~/components/views/bantenprov/zona/master-zona/MasterZonaBar02.vue';
Vue.component('master-zona-bar-02', MasterZonaBar02);

import MasterZonaBar03 from '~/components/views/bantenprov/zona/master-zona/MasterZonaBar03.vue';
Vue.component('master-zona-bar-03', MasterZonaBar03);

//... Mini Pie Charts Master Zona ...//

import MasterZonaPie01 from '~/components/views/bantenprov/zona/master-zona/MasterZonaPie01.vue';
Vue.component('master-zona-pie-01', MasterZonaPie01);

import MasterZonaPie02 from '~/components/views/bantenprov/zona/master-zona/MasterZonaPie02.vue';
Vue.component('master-zona-pie-02', MasterZonaPie02);

import MasterZonaPie03 from '~/components/views/bantenprov/zona/master-zona/MasterZonaPie03.vue';
Vue.component('master-zona-pie-03', MasterZonaPie03);
```

#### Tambahkan route di dalam file : `resources/assets/js/routes.js` :

```javascript
{
    path: '/dashboard',
    redirect: '/dashboard/home',
    component: layout('Default'),
    children: [
        //...
        // Master Zona
        {
            path: '/dashboard/master-zona',
            components: {
                main: resolve => require(['~/components/views/bantenprov/zona/master-zona/DashboardMasterZona.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Master Zona"
            }
        },
        // Zona
        {
            path: '/dashboard/zona',
            components: {
                main: resolve => require(['~/components/views/bantenprov/zona/zona/DashboardZona.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Zona"
            }
        },
        //...
    ]
},
```

```javascript
{
    path: '/admin',
    redirect: '/admin/dashboard/home',
    component: layout('Default'),
    children: [
        //...
        // Master Zona
        {
            path: '/admin/master-zona',
            components: {
                main: resolve => require(['~/components/bantenprov/zona/master-zona/MasterZona.index.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Master Zona"
            }
        },
        {
            path: '/admin/master-zona/create',
            components: {
                main: resolve => require(['~/components/bantenprov/zona/master-zona/MasterZona.add.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Add Master Zona"
            }
        },
        {
            path: '/admin/master-zona/:id',
            components: {
                main: resolve => require(['~/components/bantenprov/zona/master-zona/MasterZona.show.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "View Master Zona"
            }
        },
        {
            path: '/admin/master-zona/:id/edit',
            components: {
                main: resolve => require(['~/components/bantenprov/zona/master-zona/MasterZona.edit.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Edit Master Zona"
            }
        },
        // Zona
        {
            path: '/admin/zona',
            components: {
                main: resolve => require(['~/components/bantenprov/zona/zona/Zona.index.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Zona"
            }
        },
        {
            path: '/admin/zona/create',
            components: {
                main: resolve => require(['~/components/bantenprov/zona/zona/Zona.add.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Add Zona"
            }
        },
        {
            path: '/admin/zona/:id',
            components: {
                main: resolve => require(['~/components/bantenprov/zona/zona/Zona.show.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "View Zona"
            }
        },
        {
            path: '/admin/zona/:id/edit',
            components: {
                main: resolve => require(['~/components/bantenprov/zona/zona/Zona.edit.vue'], resolve),
                navbar: resolve => require(['~/components/Navbar.vue'], resolve),
                sidebar: resolve => require(['~/components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Edit Zona"
            }
        },
        //...
    ]
},
```
