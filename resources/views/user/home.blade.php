@extends('user.app')

@section('content')
    <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-lg p-10 mb-12 shadow-lg">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Welcome to InvestWise</h1>
        <p class="text-xl text-gray-700 mb-8">
            The future of decision support for financial investment. <br> Use the SMART Method to invest with confidences.
        </p>
        <button onclick="openSmartMethodPopup()" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-full shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
            Get to know SMART Method
        </button>
    </div>

    <h2 class="text-3xl font-bold text-gray-800 mb-8">Types of Investment</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        <a href="{{ route('investment.show', ['type' => 'emas']) }}" class="block bg-white border border-gray-200 rounded-lg shadow-md p-6 text-center hover:shadow-xl transition duration-300 ease-in-out transform hover:-translate-y-1">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Emas</h3>
            <p class="text-gray-600 text-sm">Informasi investasi emas</p>
        </a>
        <a href="{{ route('investment.show', ['type' => 'deposito']) }}" class="block bg-white border border-gray-200 rounded-lg shadow-md p-6 text-center hover:shadow-xl transition duration-300 ease-in-out transform hover:-translate-y-1">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Deposito</h3>
            <p class="text-gray-600 text-sm">Informasi investasi deposito</p>
        </a>
        <a href="{{ route('investment.show', ['type' => 'obligasi']) }}" class="block bg-white border border-gray-200 rounded-lg shadow-md p-6 text-center hover:shadow-xl transition duration-300 ease-in-out transform hover:-translate-y-1">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Obligasi</h3>
            <p class="text-gray-600 text-sm">Informasi investasi obligasi</p>
        </a>
        <a href="{{ route('investment.show', ['type' => 'reksadana']) }}" class="block bg-white border border-gray-200 rounded-lg shadow-md p-6 text-center hover:shadow-xl transition duration-300 ease-in-out transform hover:-translate-y-1">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Reksadana</h3>
            <p class="text-gray-600 text-sm">Informasi investasi reksadana</p>
        </a>
        <a href="{{ route('investment.show', ['type' => 'trading']) }}" class="block bg-white border border-gray-200 rounded-lg shadow-md p-6 text-center hover:shadow-xl transition duration-300 ease-in-out transform hover:-translate-y-1">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Trading</h3>
            <p class="text-gray-600 text-sm">Informasi investasi trading</p>
        </a>
    </div>
@endsection