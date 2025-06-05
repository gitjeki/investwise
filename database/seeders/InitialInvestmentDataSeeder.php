<?php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Criteria;
use App\Models\SubCriteria;
use App\Models\InvestmentInstrument;
use App\Models\AlternativeScore;

class InitialInvestmentDataSeeder extends Seeder
{
    public function run(): void
    {
        // Criteria Data (Updated based on image_3506eb.png)
        $criteriasData = [
            ['code' => 'C1', 'name' => 'Modal Awal', 'type' => 'cost', 'question' => 'Berapa modal awal yang rencananya ingin di investasikan?'],
            ['code' => 'C2', 'name' => 'Jangka Waktu', 'type' => 'benefit', 'question' => 'Berapa jangka waktu investasi yang kamu inginkan dalam mencapai tujuan kamu?'],
            ['code' => 'C3', 'name' => 'Risiko', 'type' => 'cost', 'question' => 'Misalnya jika nilai investasi kamu turun 15% dalam 1 bulan dengan keadaan pasar yang tidak menentu apa yang kamu lakukan?'], // Updated name
            ['code' => 'C4', 'name' => 'Imbal Hasil', 'type' => 'benefit', 'question' => 'Apa yang kamu utamakan dalam berinvestasi?'],
            ['code' => 'C5', 'name' => 'Tingkat Pengalaman', 'type' => 'benefit', 'question' => 'Seberapa paham Anda tentang reksadana, saham, kripto dan forex?'], // Updated name
            ['code' => 'C6', 'name' => 'Profil Individu', 'type' => 'benefit', 'question' => 'Dari pernyataan dibawah ini manakah yang menggambarkan dirimu ketika memiliki aset investasi?'], // Updated name
            ['code' => 'C7', 'name' => 'Kebutuhan Likuiditas', 'type' => 'benefit', 'question' => 'Seberapa mudah dan cepat suatu aset atau investasi bisa dijual atau dicairkan menjadi uang tunai tanpa menyebabkan penurunan harga yang signifikan?'], // New criteria C7 and question
        ];

        foreach ($criteriasData as $data) {
            Criteria::updateOrCreate(['code' => $data['code']], $data);
        }

        // Sub-Criteria Data (Updated based on image_3506ac.png)
        $subCriteriasOptions = [
            'C1' => [
                ['option_text' => '< 1 Juta', 'weight' => 100],
                ['option_text' => '1 - 6 Juta', 'weight' => 50],
                ['option_text' => '> 7 Juta', 'weight' => 25],
            ],
            'C2' => [
                ['option_text' => '< 1 Tahun', 'weight' => 25],
                ['option_text' => '1 - 3 Tahun', 'weight' => 50],
                ['option_text' => '3 - 5 Tahun', 'weight' => 75],
                ['option_text' => '> 5 Tahun', 'weight' => 100],
            ],
            'C3' => [ // Risiko (Cost criteria, but weight reflects preference for lower risk being higher score)
                ['option_text' => 'Cukup Rendah', 'weight' => 100],
                ['option_text' => 'Rendah', 'weight' => 75],
                ['option_text' => 'Sedang', 'weight' => 50],
                ['option_text' => 'Tinggi', 'weight' => 25],
            ],
            'C4' => [
                ['option_text' => 'Cukup Rendah', 'weight' => 25],
                ['option_text' => 'Rendah', 'weight' => 35],
                ['option_text' => 'Sedang', 'weight' => 50],
                ['option_text' => 'Tinggi', 'weight' => 75],
                ['option_text' => 'Sangat Tinggi', 'weight' => 100],
            ],
            'C5' => [ // Tingkat Pengalaman (Benefit criteria, but weight reflects preference for lower experience being higher score)
                ['option_text' => 'Sangat Terbatas', 'weight' => 100],
                ['option_text' => 'Terbatas', 'weight' => 75],
                ['option_text' => 'Baik', 'weight' => 50],
                ['option_text' => 'Sangat Baik', 'weight' => 25],
            ],
            'C6' => [ // Profil Individu (Benefit criteria, but weight reflects preference for "Terbatas" being higher score)
                ['option_text' => 'Terbatas', 'weight' => 100],
                ['option_text' => 'Sedang', 'weight' => 50],
                ['option_text' => 'Bebas', 'weight' => 25],
            ],
            'C7' => [ // Kebutuhan Likuiditas (Benefit criteria)
                ['option_text' => 'Tinggi', 'weight' => 100],
                ['option_text' => 'Sedang', 'weight' => 50],
                ['option_text' => 'Rendah', 'weight' => 25],
            ],
        ];

        foreach ($subCriteriasOptions as $criteriaCode => $options) {
            $criteria = Criteria::where('code', $criteriaCode)->first();
            if ($criteria) {
                foreach ($options as $option) {
                    $criteria->subCriterias()->updateOrCreate(
                        ['option_text' => $option['option_text'], 'criteria_id' => $criteria->id],
                        ['weight' => $option['weight']]
                    );
                }
            }
        }

        // Investment Instruments Data (Updated based on image_350688.png)
        // Note: The scores here are based on the options in image_350688.png,
        // and we need to map those options back to their numeric weights from image_3506ac.png
        $instrumentsRawData = [
            'A1' => ['Nama Alternatif' => 'Deposito Berjangka', 'C1' => '1 - 6 Juta', 'C2' => '1 - 3 Tahun', 'C3' => 'Cukup Rendah', 'C4' => 'Rendah', 'C5' => 'Sangat Terbatas', 'C6' => 'Terbatas', 'C7' => 'Sedang'],
            'A2' => ['Nama Alternatif' => 'Emas', 'C1' => '< 1 Juta', 'C2' => '> 5 Tahun', 'C3' => 'Cukup Rendah', 'C4' => 'Sedang', 'C5' => 'Sangat Terbatas', 'C6' => 'Terbatas', 'C7' => 'Tinggi'],
            'A3' => ['Nama Alternatif' => 'Obligasi SBR', 'C1' => '1 - 6 Juta', 'C2' => '3 - 5 Tahun', 'C3' => 'Cukup Rendah', 'C4' => 'Cukup Rendah', 'C5' => 'Sangat Terbatas', 'C6' => 'Terbatas', 'C7' => 'Sedang'],
            'A4' => ['Nama Alternatif' => 'Obligasi SR', 'C1' => '1 - 6 Juta', 'C2' => '3 - 5 Tahun', 'C3' => 'Cukup Rendah', 'C4' => 'Cukup Rendah', 'C5' => 'Sangat Terbatas', 'C6' => 'Terbatas', 'C7' => 'Sedang'],
            'A5' => ['Nama Alternatif' => 'Obligasi ORI', 'C1' => '1 - 6 Juta', 'C2' => '3 - 5 Tahun', 'C3' => 'Cukup Rendah', 'C4' => 'Cukup Rendah', 'C5' => 'Sangat Terbatas', 'C6' => 'Terbatas', 'C7' => 'Sedang'],
            'A6' => ['Nama Alternatif' => 'Reksadana Pasar Uang', 'C1' => '< 1 Juta', 'C2' => '1 - 3 Tahun', 'C3' => 'Cukup Rendah', 'C4' => 'Rendah', 'C5' => 'Terbatas', 'C6' => 'Sedang', 'C7' => 'Sedang'],
            'A7' => ['Nama Alternatif' => 'Reksadana Pendapatan Tetap', 'C1' => '< 1 Juta', 'C2' => '1 - 3 Tahun', 'C3' => 'Cukup Rendah', 'C4' => 'Rendah', 'C5' => 'Terbatas', 'C6' => 'Sedang', 'C7' => 'Sedang'],
            'A8' => ['Nama Alternatif' => 'Reksadana Campuran', 'C1' => '< 1 Juta', 'C2' => '1 - 3 Tahun', 'C3' => 'Sedang', 'C4' => 'Sedang', 'C5' => 'Baik', 'C6' => 'Sedang', 'C7' => 'Sedang'],
            'A9' => ['Nama Alternatif' => 'Reksadana Saham', 'C1' => '< 1 Juta', 'C2' => '1 - 3 Tahun', 'C3' => 'Cukup Rendah', 'C4' => 'Sedang', 'C5' => 'Baik', 'C6' => 'Sedang', 'C7' => 'Sedang'],
            'A10' => ['Nama Alternatif' => 'Trading Saham', 'C1' => '< 1 Juta', 'C2' => '< 1 Tahun', 'C3' => 'Rendah', 'C4' => 'Tinggi', 'C5' => 'Baik', 'C6' => 'Bebas', 'C7' => 'Tinggi'],
            'A11' => ['Nama Alternatif' => 'Trading Forex', 'C1' => '< 1 Juta', 'C2' => '< 1 Tahun', 'C3' => 'Tinggi', 'C4' => 'Sangat Tinggi', 'C5' => 'Sangat Baik', 'C6' => 'Bebas', 'C7' => 'Tinggi'],
        ];

        // Mapping sub-criteria option text to their weights
        $subCriteriaWeightMap = [];
        foreach (SubCriteria::all() as $sc) {
            $criteriaCode = $sc->criteria->code;
            $subCriteriaWeightMap[$criteriaCode][$sc->option_text] = $sc->weight;
        }

        foreach ($instrumentsRawData as $instrumentIdentifier => $data) {
            $instrumentName = $data['Nama Alternatif'];
            $instrumentType = null; // Assuming type is not explicitly given in new image

            $instrument = InvestmentInstrument::updateOrCreate(
                ['name' => $instrumentName],
                ['type' => $instrumentType] // Will be null or you can define default/lookup if needed
            );

            // Save alternative scores for each criterion based on mapped weights
            foreach ($data as $key => $value) {
                if (str_starts_with($key, 'C') && is_numeric($key[1])) {
                    $criteriaCode = $key;
                    $criteria = Criteria::where('code', $criteriaCode)->first();
                    if ($criteria && isset($subCriteriaWeightMap[$criteriaCode][$value])) {
                        $scoreValue = $subCriteriaWeightMap[$criteriaCode][$value]; // Get numeric score from map
                        AlternativeScore::updateOrCreate(
                            ['instrument_id' => $instrument->id, 'criteria_id' => $criteria->id],
                            ['score' => $scoreValue]
                        );
                    } else {
                        // Log or handle error if mapping is not found
                        $this->command->warn("Warning: No sub-criteria weight found for {$criteriaCode} option '{$value}' for instrument {$instrumentName}.");
                    }
                }
            }
        }
    }
}