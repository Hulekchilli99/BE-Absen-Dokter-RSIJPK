<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Doctor specialist names taken from the company-profile database dump.
     *
     * Formatting rules: title is `dr.`, `drg.` or `dr. dr.`, name and credentials
     * are separated by `, `, and every credential group is spaced after a comma.
     *
     * @var list<string>
     */
    private array $doctors = [
        'dr. Wening Tri Mawanti, Sp.Ok',
        'dr. H. Lukman Ali Husin, Sp.PD',
        'dr. H. Kusdiantomo, Sp.PD',
        'dr. Dewi Martalena, Sp.PD',
        'dr. Tanggo Meriza, Sp.PD, KR',
        'dr. Yuanita, Sp.PD',
        'dr. Umairah Assagaf, Sp.PD',
        'dr. Muthia Farani, Sp.PD',
        'dr. Hj. Khomimah, Sp.PD, KEMD',
        'dr. Kuspuji Dwitanto Rahardjo, Sp.PD-KGH',
        'dr. Salman Paris Harahap, Sp.PD-KHOM',
        'dr. Maulana Suryamin, Sp.PD-KGEH',
        'dr. Ika Fitriana, Sp.PD, (K) Ger',
        'dr. dr. H. M. Natsir Nugroho, Sp.OG, M.Kes',
        'dr. Hj. Husna Amelz, Sp.OG',
        'dr. Kartini, Sp.OG',
        'dr. Kalsah Nugroho Ariyanto K, Sp.OG',
        'dr. Dewi Rochyantini, Sp.OG',
        'dr. Chaeranisa Akmelia, Sp.OG',
        'dr. Nessyah Fatahan, Sp.OG',
        'dr. H. Suryono Wibowo, Sp.A',
        'dr. Roito Elmina G.H, Sp.A',
        'dr. Yunetti, Sp.A, M.Biomed',
        'dr. Siti Nurhidayah I.D, Sp.A',
        'dr. Leny Ambarwati, Sp.A',
        'dr. Raden Lia Mulyani, Sp.A',
        'dr. Tri Sunarti, Sp.A',
        'dr. Muhammad Fachri, Sp.P, FAPSR, FISR',
        'dr. H. Rahmadi Iwan G, Sp.P',
        'dr. Bobby Anggara, Sp.P',
        'dr. Andari Rahmani Putri, Sp.P, MKM',
        'dr. Flora Eka Sari, Sp.P(K) Onk',
        'dr. Arum Sari Pertiwi, MARS',
        'dr. H. Denny P. M, Sp.THT',
        'dr. Hj. Fitriah Shebubakar, Sp.THT',
        'dr. Dian Nurul Al Amini, Sp.THT',
        'dr. Hj. Hasri Darni, Sp.M',
        'dr. Masitah Wilma Wahyuni, Sp.M',
        'dr. Amelia Hidayati, Sp.M',
        'dr. Pradnya Pramitha, Sp.M',
        'dr. Atik Mufidah, Sp.JP, FIHA, M.Kes',
        'dr. Medika Prasetya, Sp.JP, FIHA',
        'dr. Gesza Utama Putra, Sp.JP',
        'dr. Irfan Taufik, Sp.S',
        'dr. Wiwin Sundawiyani, Sp.S',
        'dr. Yaumi Faiza, Sp.N, M.Biomed',
        'dr. Khonita Adian Utami, Sp.N',
        'dr. Sudirman, Sp.N',
        'dr. dr. Rini Andriani, Sp.N, Subsp.N-Onk(K)',
        'dr. Ridhawati Mukhtar, Sp.KK',
        'dr. Rizqa Haerani S, Sp.D.V.E, M.Kes, FINSDV',
        'dr. Wuriandaru Kurniasih, Sp.DV',
        'drg. Hj. Evi Hafifah, Sp.KG',
        'drg. Rini Susanti, Sp.Ort',
        'drg. Juretta Sintawati, Sp.KGA',
        'drg. Martina Ichsanti, Sp.Perio',
        'drg. Hardiono, Sp.BM',
        'drg. Arian Reza Marwan, Sp.BMM',
        'dr. Friendy Ahdimar, Sp.KJ',
        'dr. Sheery Hendrika, Sp.Akp',
        'dr. H. Saleh Setiawan, Sp.B',
        'dr. Donny Sandra, Sp.B',
        'dr. M. Riza El Anshory, Sp.B',
        'dr. Afrimal Syafarudin, Sp.B, Subsp.Onk(K), SH, MH',
        'dr. Arief Setiawan, Sp.B-KBD',
        'dr. H. Yusuf Saleh Bazed, Sp.BU',
        'dr. H. Waluyo Eko, Sp.BU',
        'dr. Raga Manduaru, Sp.U',
        'dr. Sumono Handoyo, Sp.OT, FICS',
        'dr. Mahardhika Ichsantyaridha, Sp.OT, AIFO-K',
        'dr. Mohammad Walid Kuncoro, Sp.OT',
        'dr. Ilham Suryo Wibowo Antono, Sp.OT',
        'dr. Rally Galang P.P, Sp.BTKV',
        'dr. Endi Suryo Utomo, Sp.BS',
        'dr. Alvin Abrar Harahap, Sp.BS',
        'dr. Livia Faranita Gianni, Sp.BP-RE',
        'dr. Elly Triturawati, Sp.RM',
        'dr. Rahmania Noor Adiba, Sp.KFR',
        'dr. Umi Sjarqiah, Sp.KFR, MKM',
        'dr. Evi Rachmawati Nur Hidayati, Sp.KFR, Ger(K), FIPM(USG), Ph.D',
        'dr. R. Suryoseto, Sp.Rad(K) Onk.Rad',
        'dr. dr. Irwan Ramli, Sp.Onk.Rad (RAPI), Subsp. A.P (K)',
    ];

    /**
     * Previously seeded spellings mapped onto their canonical name, so existing
     * rows (and their attendance history) are renamed instead of duplicated.
     *
     * @var array<string, string>
     */
    private array $renames = [
        'dr. Tanggo Meriza. Sp.PD, KR' => 'dr. Tanggo Meriza, Sp.PD, KR',
        'dr. Salman Paris Harahap Sp.PD.KHOM' => 'dr. Salman Paris Harahap, Sp.PD-KHOM',
        'dr. Maulana Suryamin, Sp PD-KGEH' => 'dr. Maulana Suryamin, Sp.PD-KGEH',
        'dr.Ika Fitriana, Sp.PD, (K) Ger' => 'dr. Ika Fitriana, Sp.PD, (K) Ger',
        'DR dr.H.M.Natsir Nugroho, Sp.OG, M.Kes' => 'dr. dr. H. M. Natsir Nugroho, Sp.OG, M.Kes',
        'dr.Nessyah Fatahan Sp.OG' => 'dr. Nessyah Fatahan, Sp.OG',
        'dr. Yunetti, Sp.A., M.Biomed' => 'dr. Yunetti, Sp.A, M.Biomed',
        'dr. Muhammad Fachri, Sp.P, FAPSR.,FISR' => 'dr. Muhammad Fachri, Sp.P, FAPSR, FISR',
        'dr. Andari Rahmani Putri, Sp.P.MKM' => 'dr. Andari Rahmani Putri, Sp.P, MKM',
        'dr. Flora Eka Sari, Sp.P(K)Onk' => 'dr. Flora Eka Sari, Sp.P(K) Onk',
        'dr. H. Denny. P. M,Sp.THT' => 'dr. H. Denny P. M, Sp.THT',
        'dr. Amelia Hidayati , Sp.M' => 'dr. Amelia Hidayati, Sp.M',
        'dr. Atik Mufidah, Sp.JP., FIHA., M.Kes' => 'dr. Atik Mufidah, Sp.JP, FIHA, M.Kes',
        'dr. Medika Prasetya, Sp.JP,FIHA' => 'dr. Medika Prasetya, Sp.JP, FIHA',
        'dr.Gesza Utama Purta, Sp. JP' => 'dr. Gesza Utama Putra, Sp.JP',
        'dr. Irfan Taufik,Sp.S' => 'dr. Irfan Taufik, Sp.S',
        'dr. Yaumi Faiza, Sp.N, M.BioMed' => 'dr. Yaumi Faiza, Sp.N, M.Biomed',
        'Dr. dr. Rini Andriani, Sp. N, Sussp.N-Onk(K)' => 'dr. dr. Rini Andriani, Sp.N, Subsp.N-Onk(K)',
        'dr. Rizqa Haerani. S, Sp.D.V.E.,M.Kes.,FINSDV' => 'dr. Rizqa Haerani S, Sp.D.V.E, M.Kes, FINSDV',
        'drg Arian Reza Marwan, Sp.BMM' => 'drg. Arian Reza Marwan, Sp.BMM',
        'dr. Afrimal Syafarudin, Sp.B,Subsp.Onk(K), SH,MH' => 'dr. Afrimal Syafarudin, Sp.B, Subsp.Onk(K), SH, MH',
        'dr. Arief Setiawan, SpB-KBD' => 'dr. Arief Setiawan, Sp.B-KBD',
        'dr. Alvin Abrar Harahap Sp.BS' => 'dr. Alvin Abrar Harahap, Sp.BS',
        'dr.Ilham Suryo Wibowo Antono, Sp.OT' => 'dr. Ilham Suryo Wibowo Antono, Sp.OT',
        'dr Rahmania Noor Adiba, Sp.KFR' => 'dr. Rahmania Noor Adiba, Sp.KFR',
        'dr. Umi Sjarqiah, Sp. KFR.,MKM' => 'dr. Umi Sjarqiah, Sp.KFR, MKM',
        'dr. Evi Rachmawati Nur Hidayati, Sp. KFR,Ger(K),FIPM(USG),Ph.D' => 'dr. Evi Rachmawati Nur Hidayati, Sp.KFR, Ger(K), FIPM(USG), Ph.D',
        'Dr. dr. Irwan Ramli, Sp.Onk.Rad (RAPI), Subsp. A.P (K)' => 'dr. dr. Irwan Ramli, Sp.Onk.Rad (RAPI), Subsp. A.P (K)',
        'dr. Umi Sjarqiyah' => 'dr. Umi Sjarqiah, Sp.KFR, MKM',
        'dr. Evi Rachmawati Nur Hidayati, Sp.KFR' => 'dr. Evi Rachmawati Nur Hidayati, Sp.KFR, Ger(K), FIPM(USG), Ph.D',
        'DR.dr. Flora Eka Sari' => 'dr. Flora Eka Sari, Sp.P(K) Onk',
        'dr. MAULANA SURYAMIN' => 'dr. Maulana Suryamin, Sp.PD-KGEH',
        'dr. IKA FITRIANA,SpPD,KGer' => 'dr. Ika Fitriana, Sp.PD, (K) Ger',
        'dr. Irwan Ramli, Sp. Rad(K),Onk,Rad' => 'dr. dr. Irwan Ramli, Sp.Onk.Rad (RAPI), Subsp. A.P (K)',
        'DR RINI ANDRIANI SP.N' => 'dr. dr. Rini Andriani, Sp.N, Subsp.N-Onk(K)',
    ];

    /**
     * Bare names left over from the previous dataset: inactive rows without any
     * title, none of them part of the roster.
     *
     * @var list<string>
     */
    private array $legacyBareNames = [
        'Aditarahma Imaningdyah',
        'Afrimal Syafarudin',
        'Ahmad Judianto',
        'Amelia Hidayati',
        'Andari Rahmani',
        'Arian Reza Marwan',
        'Arief Setiawan',
        'Chaerannisa Akmelia',
        'Denny P Machmud',
        'Dewi Rochyantini',
        'Dian Nurul Al Amini',
        'Ekky Sri Rejeki',
        'Elly Triturawati',
        'Endi Suryo Utomo',
        'Evi Hafifah',
        'Fitriah Shebubakar',
        'Friendy Ahdimar',
        'Hardiono',
        'Hasri Darni',
        'Husna Amelz',
        'Imy Ginting',
        'Indra Budi Perkasa',
        'Irfan Taufik',
        'Jaka Fatria Yudhistira',
        'Juretta Sintawati',
        'Kalsah Nugroho Aryanto',
        'Khomimah',
        'Khonita Adian Utami',
        'Kusdiantomo',
        'Kuspuji Dwitanto Rahardjo',
        'Leni Ambarwati',
        'Litta Septina Mahmelia Zaid',
        'Livia Faranita Gianni',
        'Lukman Ali Husin',
        'M Natsir Nugroho',
        'Mahardika Ichsantyaridha',
        'Martina Ichsanti',
        'Masitah Wilya Wahyuni',
        'Mohamad Syarifudin',
        'Mohamad Walid Kuncoro',
        'Muhammad Fachri',
        'Murtiyas Galuh',
        'Muthia Farani',
        'Pradnya Pramitha',
        'Pramafitri Adi Patria',
        'R Suryoseto',
        'Raden Lia Mulyani',
        'Raga Manduaru',
        'Rahmadi Iwan Guntoro',
        'Rahmania Noor Adiba',
        'Rally Galang Pratama Putra',
        'Reny Luhur Setiyani',
        'Ridhawati Mukhtar',
        'Rini Susanti',
        'Rizqa Haerani',
        'Saleh Setiawan',
        'Salman Paris Harahap',
        'Salmy Nazir',
        'Sherry Hendrika',
        'Siti Nurhidayah Idi Daud',
        'Sudirman',
        'Suginem Mudjiantoro',
        'Sumono Handoyo',
        'Suryono Wibowo',
        'Tanggo Meriza',
        'Tri Sunarti Wahyutami',
        'Umairah Assegaf',
        'Waluyo Eko Sutarto',
        'Wiwin Sundawiyani',
        'Wuriandaru Kurniasih',
        'Yaumi Faiza',
        'Yuanita',
        'Yusuf Saleh Bazed',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->renameLegacyNames();

        foreach ($this->doctors as $name) {
            Doctor::firstOrCreate(
                ['name' => $name],
                ['is_active' => true],
            );
        }

        Doctor::query()
            ->whereIn('name', $this->doctors)
            ->update(['is_active' => true]);

        Doctor::query()
            ->whereNotIn('name', $this->doctors)
            ->update(['is_active' => false]);

        $this->removeLegacyBareNames();
    }

    /**
     * Move rows still holding an outdated spelling onto their canonical name.
     * When the canonical name is already taken by a duplicate of the same
     * doctor, both rows are merged so attendance history stays on one doctor.
     */
    private function renameLegacyNames(): void
    {
        foreach ($this->renames as $legacyName => $canonicalName) {
            $legacyDoctor = Doctor::query()
                ->where('name', $legacyName)
                ->first();

            if ($legacyDoctor === null) {
                continue;
            }

            $canonicalDoctor = Doctor::query()
                ->where('name', $canonicalName)
                ->first();

            if ($canonicalDoctor === null) {
                $legacyDoctor->update(['name' => $canonicalName]);

                continue;
            }

            if ($legacyDoctor->is_active) {
                $this->mergeDoctor(source: $canonicalDoctor, target: $legacyDoctor);
                $legacyDoctor->update(['name' => $canonicalName]);

                continue;
            }

            $this->mergeDoctor(source: $legacyDoctor, target: $canonicalDoctor);
        }
    }

    /**
     * Move the attendance history of a duplicated doctor onto the surviving row.
     * Same-day records already present on the survivor are dropped, because the
     * schema allows one attendance per doctor per day.
     */
    private function mergeDoctor(Doctor $source, Doctor $target): void
    {
        $existingDates = $target->attendances()->pluck('attendance_date');

        $source->attendances()
            ->when(
                $existingDates->isNotEmpty(),
                fn ($query) => $query->whereNotIn('attendance_date', $existingDates->all()),
            )
            ->update(['doctor_id' => $target->id]);

        $source->attendances()->delete();
        $source->delete();
    }

    /**
     * Drop the leftover rows of the previous dataset. Rows that still carry
     * attendance history are kept, so no record is ever lost to a seed run.
     */
    private function removeLegacyBareNames(): void
    {
        Doctor::query()
            ->where('is_active', false)
            ->whereIn('name', $this->legacyBareNames)
            ->whereDoesntHave('attendances')
            ->delete();
    }
}
