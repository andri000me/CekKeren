<?php
/**
 * Konfigurasi dasar WordPress.
 *
 * Berkas ini berisi konfigurasi-konfigurasi berikut: Pengaturan MySQL, Awalan Tabel,
 * Kunci Rahasia, Bahasa WordPress, dan ABSPATH. Anda dapat menemukan informasi lebih
 * lanjut dengan mengunjungi Halaman Codex {@link http://codex.wordpress.org/Editing_wp-config.php
 * Menyunting wp-config.php}. Anda dapat memperoleh pengaturan MySQL dari web host Anda.
 *
 * Berkas ini digunakan oleh skrip penciptaan wp-config.php selama proses instalasi.
 * Anda tidak perlu menggunakan situs web, Anda dapat langsung menyalin berkas ini ke
 * "wp-config.php" dan mengisi nilai-nilainya.
 *
 * @package WordPress
 */

// ** Pengaturan MySQL - Anda dapat memperoleh informasi ini dari web host Anda ** //
/** Nama basis data untuk WordPress */
define( 'DB_NAME', 'cekkeren' );

/** Nama pengguna basis data MySQL */
define( 'DB_USER', 'root' );

/** Kata sandi basis data MySQL */
define( 'DB_PASSWORD', '' );

/** Nama host MySQL */
define( 'DB_HOST', 'localhost' );

/** Set Karakter Basis Data yang digunakan untuk menciptakan tabel basis data. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Jenis Collate Basis Data. Jangan ubah ini jika ragu. */
define('DB_COLLATE', '');

/** install tanpa ftp. */
define('FS_METHOD','direct');

/**#@+
 * Kunci Otentifikasi Unik dan Garam.
 *
 * Ubah baris berikut menjadi frase unik!
 * Anda dapat menciptakan frase-frase ini menggunakan {@link https://api.wordpress.org/secret-key/1.1/salt/ Layanan kunci-rahasia WordPress.org}
 * Anda dapat mengubah baris-baris berikut kapanpun untuk mencabut validasi seluruh cookies. Hal ini akan memaksa seluruh pengguna untuk masuk log ulang.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'c3X/Hc.(Q=i+7)bg|*22aN#|OpPD)Rs0:EGwSvi:0/HKRo^o7{/*|l3tB@-E)rz[' );
define( 'SECURE_AUTH_KEY',  '?2>~d6]$#wY8E{jIPtbf0a(N^@)C) ]L0WK0`o/8@1oG?p%dSF(wB~}<*$N]tt$ ' );
define( 'LOGGED_IN_KEY',    'Glv7/sYh|[yo4M83gXFSMa(Z=H7g6b.`Q8p.w#%WQn:bZn!5QaZxs>ATZ}OT70=H' );
define( 'NONCE_KEY',        '$p^/Y2:[8iQp$#+sUdcayu+wBR5~X^1mPb(V:3~Hewf@9{}iu89rgHQwevhWH-OE' );
define( 'AUTH_SALT',        'Kqx8rz4a^u3^H%%7nZr&Gh}6up-OQg!TNdRA-GnIFczGL~ul0tNJ+x%I(vSO(kZ/' );
define( 'SECURE_AUTH_SALT', '&1JI~SWclG80.8LEz)}k6ppDlUE]9>:W=5%X_iY%X?M}fxA6*LDHpb(f|n~uMsC}' );
define( 'LOGGED_IN_SALT',   '^vn>|h_~%SclBSi-{HR!iS;N3D(Em.Pj5~ByTVm!.M@{T8m_S,P?(q0-JWWf6%<l' );
define( 'NONCE_SALT',       ';+g9o1*`Ag5l*6(8_C%@^-R~-`<FYPvIJO%>[ivx@hc}a>q33R5-Lm^OJ]~CufBd' );

/**#@-*/

/**
 * Awalan Tabel Basis Data WordPress.
 *
 * Anda dapat memiliki beberapa instalasi di dalam satu basis data jika Anda memberikan awalan unik
 * kepada masing-masing tabel. Harap hanya masukkan angka, huruf, dan garis bawah!
 */
$table_prefix = 'wp_';

/**
 * Untuk pengembang: Moda pengawakutuan WordPress.
 *
 * Ubah ini menjadi "true" untuk mengaktifkan tampilan peringatan selama pengembangan.
 * Sangat disarankan agar pengembang plugin dan tema menggunakan WP_DEBUG
 * di lingkungan pengembangan mereka.
 */
define('WP_DEBUG', true);

/* Cukup, berhenti menyunting! Selamat ngeblog. */

/** Lokasi absolut direktori WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Menentukan variabel-variabel WordPress berkas-berkas yang disertakan. */
require_once(ABSPATH . 'wp-settings.php');
