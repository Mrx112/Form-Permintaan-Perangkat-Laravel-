<p>Halo {{ $newUser->name }},</p>

<p>Seorang pengguna baru telah mendaftar dengan email <strong>{{ $newUser->email }}</strong> dan menunggu persetujuan Anda sebagai admin.</p>

<p>Silakan klik tombol di bawah untuk mengirim email aktivasi kepada pengguna tersebut:</p>

<p>
    <a href="{{ route('admin.users.sendActivation', $newUser->id) }}" style="background:#2563eb;color:#fff;padding:8px 12px;border-radius:4px;text-decoration:none;">Kirim Email Aktivasi ke Pengguna</a>
</p>

<p>Atau buka halaman manajemen user untuk memproses permintaan.</p>

<p>Terima kasih.</p>
