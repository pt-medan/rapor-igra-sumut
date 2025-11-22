{{-- @var $user \App\Models\User --}}
        <section>
            <header>
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Informasi Profil') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ __("Perbarui informasi profil akun dan alamat email Anda.") }}
                </p>
            </header>    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        @if ($user->guru) {{-- @phpstan-ignore-line --}}
            <div>
                <x-input-label for="nama_guru" :value="__('Nama Guru')" />
                <x-text-input id="nama_guru" name="nama_guru" type="text" class="mt-1 block w-full" :value="old('nama_guru', $user->guru->nama_guru)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('nama_guru')" />
            </div>
        @endif

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Alamat email Anda belum diverifikasi.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        @if ($user->guru) {{-- @phpstan-ignore-line --}}
            <div>
                <x-input-label for="nip" :value="__('NIP')" />
                <x-text-input id="nip" name="nip" type="text" class="mt-1 block w-full" :value="old('nip', $user->guru->nip)" />
                <x-input-error class="mt-2" :messages="$errors->get('nip')" />
            </div>
        @endif

        @if ($user->guru) {{-- @phpstan-ignore-line --}}
            <div>
                <x-input-label for="telepon" :value="__('Telepon')" />
                <x-text-input id="telepon" name="telepon" type="text" class="mt-1 block w-full" :value="old('telepon', $user->guru->telepon)" />
                <x-input-error class="mt-2" :messages="$errors->get('telepon')" />
            </div>
        @endif

        @if ($user->guru) {{-- @phpstan-ignore-line --}}
            <div>
                <x-input-label for="alamat" :value="__('Alamat')" />
                <x-text-input id="alamat" name="alamat" type="text" class="mt-1 block w-full" :value="old('alamat', $user->guru->alamat)" />
                <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
            </div>
        @endif

        @if ($user->guru?->sekolah) {{-- @phpstan-ignore-line --}}
            <div>
                <x-input-label for="sekolah" :value="__('Sekolah')" />
                <x-text-input id="sekolah" name="sekolah" type="text" class="mt-1 block w-full" :value="$user->guru->sekolah->nama_sekolah" readonly />
            </div>
        @endif

        @if ($user->guru?->kelompokKelas) {{-- @phpstan-ignore-line --}}
            <div>
                <x-input-label for="kelompok_kelas" :value="__('Kelompok Kelas')" />
                <x-text-input id="kelompok_kelas" name="kelompok_kelas" type="text" class="mt-1 block w-full" :value="$user->guru->kelompokKelas->nama_kelompok ?? 'Belum menjadi wali kelas'" readonly />
            </div>
        @endif

        @if ($user->guru?->kelompokKelas) {{-- @phpstan-ignore-line --}}
            <div>
                <x-input-label for="tahun_ajaran" :value="__('Tahun Ajaran')" />
                <x-text-input id="tahun_ajaran" name="tahun_ajaran" type="text" class="mt-1 block w-full" :value="$user->guru->kelompokKelas->tahun_ajaran ?? 'Belum menjadi wali kelas'" readonly />
            </div>
        @endif


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>
