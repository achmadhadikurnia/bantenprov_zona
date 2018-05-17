1. Pecah menu Zona menjadi dua bagian, satu untuk admin sekolah satu lagi untuk administrator

-- Menu admin sekolah

```javascript
{
    name: 'Admin Sekolah',
    icon: 'fa fa-lock',
    childType: 'collapse',
    childItem: [
        //...
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

-- Menu administrator

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
        //...
    ]
},
```
