<?php

use App\Http\Controllers\Member\AjaxController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Member\KasirController;
use App\Http\Controllers\Member\BannerController;
use App\Http\Controllers\Member\HomeController;
use App\Http\Controllers\Member\KategoriController;
use App\Http\Controllers\Member\MemberController;
use App\Http\Controllers\Member\PengaturanController;
use App\Http\Controllers\Member\PasswordController;
use App\Http\Controllers\Member\PermissionController;
use App\Http\Controllers\Member\ProdukController;
use App\Http\Controllers\Member\ProfilController;
use App\Http\Controllers\Member\RoleController;
use App\Http\Controllers\Member\SuplierController;
use App\Http\Controllers\Member\UnitController;
use App\Http\Controllers\Member\UserController;
use App\Http\Controllers\Member\StokInController;
use App\Http\Controllers\Member\StokOutController;
use App\Http\Controllers\Member\TransaksiController;
use Illuminate\Support\Facades\Route;


Route::middleware('xss')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('auth.login');
    Route::post('/login', [LoginController::class, 'login'])->name('auth.login.post');

    Route::middleware(['auth'])->prefix('auth')->group(function () {
        Route::get('/keluar', [LoginController::class, 'logout'])->name('auth.keluar');
        Route::get('/', [HomeController::class, 'index'])->name('auth.index');

        Route::singleton('profil', ProfilController::class);
        Route::resource('password', PasswordController::class);

        Route::prefix('chart')->group(function () {
            Route::post('/summary-transaction', [HomeController::class, 'summaryTransaction'])->name('chart.summary.transaction');
            Route::post('/daily-transaction', [HomeController::class, 'dailyTransaction'])->name('chart.daily.transaction');
            Route::post('/member-transaction', [HomeController::class, 'memberTransaction'])->name('chart.member.transaction');
        });

        Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
        Route::post('/kasir/bayar', [KasirController::class, 'bayar'])->name('kasir.bayar');
        Route::post('/kasir/transaksi', [TransaksiController::class, 'ajax'])->name('kasir.transaksi');
        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::get('/transaksi/{transaksi}', [TransaksiController::class, 'show'])->name('transaaksi.show');

        Route::resource('kategori', KategoriController::class);
        Route::post('/kategori-ajax', [KategoriController::class, 'ajax'])->name('kategori.ajax');

        Route::resource('produk', ProdukController::class);
        Route::post('/produk-ajax', [ProdukController::class, 'ajax'])->name('produk.ajax');
        Route::get('/produk/id/{id}', [ProdukController::class, 'showById']);
        Route::post('/produk/cariproduk', [ProdukController::class, 'cariProduk']);
        Route::get('/asd', [ProdukController::class, 'listProduk'])->name('produk.list');

        Route::resource('suplier', SuplierController::class);
        Route::post('/suplier-ajax', [SuplierController::class, 'ajax'])->name('suplier.ajax');

        Route::resource('unit', UnitController::class);
        Route::post('/unit-ajax', [UnitController::class, 'ajax'])->name('unit.ajax');

        Route::resource('member', MemberController::class);
        Route::post('/member-ajax', [MemberController::class, 'ajax'])->name('member.ajax');
        Route::post('/member/password', [MemberController::class, 'password'])->name('member.password');
        Route::post('/member/customer', [MemberController::class, 'cariCustomer'])->name('member.customer');

        Route::get('/stokin', [StokInController::class, 'index'])->name('stokin.index');
        Route::post('/stokin-ajax', [StokInController::class, 'ajax'])->name('stokin.ajax');
        Route::get('/stokin/show/{uuid}', [StokInController::class, 'show'])->name('stokin.show');
        Route::get('/stokin/create', [StokInController::class, 'create'])->name('stokin.create');
        Route::post('/stokin', [StokInController::class, 'store'])->name('stokin.store');

        Route::get('/stokout', [StokOutController::class, 'index'])->name('stokout.index');
        Route::post('/stokout-ajax', [StokOutController::class, 'ajax'])->name('stokout.ajax');
        Route::get('/stokout/show/{uuid}', [StokOutController::class, 'show'])->name('stokout.show');
        Route::get('/stokout/create', [StokOutController::class, 'create'])->name('stokout.create');
        Route::post('/stokout', [StokOutController::class, 'store'])->name('stokout.store');

        Route::resource('banner', BannerController::class);
        Route::post('/banner-ajax', [BannerController::class, 'ajax'])->name('banner.ajax');


        Route::resource('user', UserController::class);
        Route::post('/user-ajax', [UserController::class, 'ajax'])->name('user.ajax');
        Route::post('/user/password/{user}', [UserController::class, 'password'])->name('user.password');

        Route::resource('role', RoleController::class);
        Route::post('/role-ajax', [RoleController::class, 'ajax'])->name('role.ajax');

        Route::post('/permission-ajax', [PermissionController::class, 'ajax'])->name('permission.ajax');

        Route::singleton('pengaturan', PengaturanController::class);

        Route::prefix('master')->group(function () {
            Route::post('/ganti-foto', [AjaxController::class, 'ganti_foto'])->name('master.foto');
            Route::post('/ganti-pdf', [AjaxController::class, 'ganti_pdf'])->name('master.pdf');

            Route::post('/provinsi', [AjaxController::class, 'provinsi'])->name('drop-provinsi');
            Route::post('/kota', [AjaxController::class, 'kota'])->name('drop-kota');
            Route::post('/kecamatan', [AjaxController::class, 'kecamatan'])->name('drop-kecamatan');
            Route::post('/kategori', [AjaxController::class, 'kategori'])->name('drop-kategori');
            Route::post('/unit', [AjaxController::class, 'unit'])->name('drop-unit');
            Route::post('/produk', [AjaxController::class, 'produk'])->name('drop-produk');
            Route::post('/suplier', [AjaxController::class, 'suplier'])->name('drop-suplier');
        });
    });
});
