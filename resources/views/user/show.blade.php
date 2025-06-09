@extends('user.app')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Informasi Investasi: {{ ucfirst($type) }}</h1>

    @if ($type == 'emas')
        <div class="bg-white p-6 rounded-lg shadow-md">
            <p class="text-gray-700 leading-relaxed">
                Investasi emas adalah salah satu bentuk investasi tertua dan sering dianggap sebagai safe haven di masa ketidakpastian ekonomi. Emas dapat diinvestasikan dalam bentuk fisik (batangan, koin, perhiasan) atau non-fisik (reksa dana emas, tabungan emas digital). Keuntungannya meliputi perlindungan nilai dari inflasi dan krisis ekonomi, serta likuiditas yang tinggi. Namun, perlu diperhatikan bahwa harga emas bisa berfluktuasi dan tidak menghasilkan pendapatan pasif seperti dividen atau bunga.
            </p>
        </div>
    @elseif ($type == 'deposito')
        <div class="bg-white p-6 rounded-lg shadow-md">
            <p class="text-gray-700 leading-relaxed">
                Deposito adalah produk perbankan yang menawarkan suku bunga tetap untuk jangka waktu tertentu. Deposito umumnya dianggap sebagai investasi berisiko rendah karena pokok investasi dan bunga dijamin oleh Lembaga Penjamin Simpanan (LPS) hingga batas tertentu. Cocok untuk investor konservatif yang mencari keamanan dan pendapatan yang stabil. Namun, imbal hasilnya cenderung lebih rendah dibandingkan investasi dengan risiko lebih tinggi, dan dana Anda akan terkunci selama periode deposito.
            </p>
        </div>
    @elseif ($type == 'obligasi')
        <div class="bg-white p-6 rounded-lg shadow-md">
            <p class="text-gray-700 leading-relaxed">
                Obligasi adalah surat utang yang diterbitkan oleh pemerintah atau perusahaan untuk mendapatkan dana. Investor yang membeli obligasi akan menerima pembayaran bunga (kupon) secara berkala dan pengembalian pokok pada saat jatuh tempo. Obligasi memiliki risiko yang bervariasi tergantung pada penerbitnya. Obligasi pemerintah umumnya lebih aman daripada obligasi korporasi. Investasi obligasi cocok untuk investor yang mencari pendapatan tetap dan diversifikasi portofolio.
            </p>
        </div>
    @elseif ($type == 'reksadana')
        <div class="bg-white p-6 rounded-lg shadow-md">
            <p class="text-gray-700 leading-relaxed">
                Reksadana adalah wadah untuk menghimpun dana dari masyarakat pemodal untuk selanjutnya diinvestasikan dalam portofolio efek oleh manajer investasi. Ada berbagai jenis reksa dana seperti reksa dana pasar uang, reksa dana pendapatan tetap, reksa dana saham, dan reksa dana campuran. Keuntungan reksa dana adalah diversifikasi portofolio secara otomatis dan pengelolaan profesional. Cocok untuk investor pemula yang ingin berinvestasi tanpa perlu menganalisis pasar secara mendalam.
            </p>
        </div>
    @elseif ($type == 'trading')
        <div class="bg-white p-6 rounded-lg shadow-md">
            <p class="text-gray-700 leading-relaxed">
                Trading melibatkan pembelian dan penjualan instrumen keuangan (seperti saham, forex, komoditas, atau kripto) dalam jangka pendek dengan tujuan mendapatkan keuntungan dari fluktuasi harga. Trading memiliki potensi keuntungan yang tinggi, tetapi juga disertai risiko yang tinggi. Membutuhkan pengetahuan pasar yang mendalam, analisis teknikal, dan manajemen risiko yang baik. Trading tidak disarankan untuk pemula tanpa edukasi dan latihan yang cukup.
            </p>
        </div>
    @else
        <p class="text-lg text-red-600">Tipe investasi tidak ditemukan.</p>
    @endif

    <div class="mt-8">
        <a href="{{ route('home') }}" class="text-green-600 hover:underline">&larr; Kembali ke Home</a>
    </div>
@endsection