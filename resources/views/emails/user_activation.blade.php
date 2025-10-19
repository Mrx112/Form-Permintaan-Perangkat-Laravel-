<p>Halo {{ $user->name }},</p>

<p>Administrator telah meninjau pendaftaran Anda. Silakan klik tautan di bawah untuk mengaktifkan akun Anda:</p>

<p>
    <a href="{{ route('auth.activate', $user->approval_token) }}" style="background:#10b981;color:#fff;padding:8px 12px;border-radius:4px;text-decoration:none;">Aktifkan Akun</a>
</p>

<p>Jika Anda tidak melakukan pendaftaran, abaikan email ini.</p>

<p>Terima kasih.</p>
