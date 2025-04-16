<?php

namespace Concrete\Package\LazyScroll;

use Bitter\LazyScroll\Provider\ServiceProvider;
use Concrete\Core\Entity\Package as PackageEntity;
use Concrete\Core\Package\Package;

class Controller extends Package
{
    protected string $pkgHandle = 'lazy_scroll';
    protected string $pkgVersion = '0.0.1';
    protected $appVersionRequired = '9.0.0';
    protected $pkgAutoloaderRegistries = [
        'src/Bitter/LazyScroll' => 'Bitter\LazyScroll',
    ];

    public function getPackageDescription(): string
    {
        return t('Lazy Scroll is a Concrete CMS extension that brings ultra-smooth, modern scrolling animations to your website with One-Click-Installation.');
    }

    public function getPackageName(): string
    {
        return t('Lazy Scroll');
    }

    public function on_start()
    {
        /** @var ServiceProvider $serviceProvider */
        /** @noinspection PhpUnhandledExceptionInspection */
        $serviceProvider = $this->app->make(ServiceProvider::class);
        $serviceProvider->register();
    }

    public function install(): PackageEntity
    {
        $pkg = parent::install();
        $this->installContentFile("data.xml");
        return $pkg;
    }

    public function upgrade()
    {
        parent::upgrade();
        $this->installContentFile("data.xml");
    }
}