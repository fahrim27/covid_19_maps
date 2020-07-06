<?php

use App\Kecamatan;
use App\Kelurahan;
use Illuminate\Database\Seeder;

class WilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["nama" => "Balongbendo", "kelurahan" => ["Balongbendo","Bakalan Wringinpitu","Bakung Pringgodani","Bakung Temenggungan","Balongbendo", "Bogem Pinggir", "Gagang Kepuhsari", "Jabaran", "Jeruk Legi", "Kedung Sukodani", "Kemangsen", "Penambangan", "Seduri", "Seketi", "Singkalan", "Sumokembangsri", "Suwaluh", "Waruberon", "Watesari", "Wonokarang", "Wonokupang"]],
            ["nama" => "Buduran", "kelurahan" => ["Banjarkemantren","Banjarsari","Buduran","Damarsi","Dukuhtengah","Entalsewu","Pagerwojo","Prasung","Sawohan","Sidokepung","Sidokerto","Sidomulyo","Siwalan Panji","Sukorejo", "Wadungasih"]],
            ["nama" => "Candi", "kelurahan" => ["Balongdowo","Balonggabus","Bligo","Candi","Durungbanjar","Durungbedug","Gelam","Jambangan","Kalipecabean","Karangtanjung","Kebunsari","Kedung Peluk","Kedungkendo","Kendalpecabean","Klurak","Larangan","Ngampelsari","Sepande","Sidodadi","Sugih Waras","Sumokali","Sumorame","Tenggulunan","Wedoro Klurak"]],
            ["nama" => "Gedangan", "kelurahan" => ["Bangah","Ganting","Gedangan","Gemurung","Karangbong","Keboananom","Keboansikep","Ketajen","Kragan","Punggul","Sawotratap","Semambung","Sruni","Tebel","Wedi"]],
            ["nama" => "Jabon", "kelurahan" => ["Balongtani","Besuki","Dukuhsari","Jemirahan","Keboguyang","Kedungcangkring","Kedungpandan","Kedungrejo","Kupang","Panggreh","Pejarakan","Permisan","Semambung","Tambak Kalisogo","Trompoasri"]],
            ["nama" => "Krembung", "kelurahan" => ["Balong Garut","Cangkring","Gading","Jenggot","Kandangan","Kedungrawan","Kedungsumur","Keper","Keret","Krembung","Lemujut","Mojoruntut","Ploso","Rejeni","Tambakrejo","Tanjeg Wagir","Wangkal","Waung","Wonomlati"]],
            [ "nama" => "Krian", "kelurahan" => ["Barengkrajan", "Gamping","Jatikalang","Jeruk Gamping","Junwang","Katrungan","Keboharan","Kemasan","Kraton","Krian","Ponokawan","Sedengan Mijen","Sidomojo","Sidomulyo","Sidorejo","Tambak Kemerakan","Tempel","Terik","Terung Kulon","Terung Wetan","Tropodo","Watugolong"]],
            ["nama" => "Porong", "kelurahan" => ["Candipari","Gedang","Glagah Arum ","Jatirejo","Juwet Kenongo","Kebakalan","Kebonagung","Kedungboto","Kedungsolo","Kesambi","Lajuk","Mindi","Pamotan","Pesawahan","Plumbon","Porong","Renokenongo","Siring","Wunut"]],
            ["nama" => "Prambon", "kelurahan" => ["Bendotretek","Bulang","Cangkringturi","Gampang","Gedangrowo","Jatialunalun","Jatikalang","Jedongcangkring","Kajartrengguli","Kedungkembar","Kedungsugo","Kedungwonokerto","Pejangkungan","Prambon","Simogirang","Simpang","Temu","Watutulis","Wirobiting","Wonoplintahan"]],
            ["nama" => "Porong", "kelurahan" => ["Kedungsolo","Pesawahan","Lajuk","Kebonagung","Pamotan","Kedungboto","Candipari","Kebakalan","Plumbon","Glagaharum","Kesambi","Reno Kenongo","Wunut","Porong","Mindi","Juwetkenongo","Gedang","Siring","Jatirejo"]],
            ["nama" => "Sedati", "kelurahan" => ["Banjarkemuningtambak","Betro","Buncitan","Cemandi","Gisikcemandi","Kalanganyar","Kwangsan","Pabean","Pepe","Pranti","Pulungan","Sedatiagung","Sedatigede","Segorotambak","Semampir","Tambakcemandi"]],
            ["nama" => "Sidoarjo", "kelurahan" => ["Banjarbendo","Bluru Kidul","Cemengbakalan","JatiKemiri","Lebo","Rangka Kidul","Sarirogo","SukoSumput","Bulusidokare","Celep","Cemengkalang","Gebang","Lemahputro","Magersari","Pekauman","Pucang","Pucanganom","Sekardangan","Sidokare","Sidoklumpuk","Sidokumpul","Urangagung"]],
            ["nama" => "Sukodono", "kelurahan" => ["Anggaswangi","Bangsri","Cangkringsari","Jumputrejo","Kebonagung","Keloposepuluh","Jogosatru","Masangankulon","Masanganwetan","Ngaresrejo","Pademonegoro","Panjunan","Pekarungan","Plumbungan","Sambungrejo","Sukodono","Sukolegok","Suruh","Wilayut"]],
            ["nama" => "Taman", "kelurahan" => ["Bohar","Bringinbendo","Geluran","Gilang","Jemundo","Kedungturi","Kragan","Kletek","Kramatjegu","Krembangan","Pertapan Maduretno","Sadang","Sambibulu","Sidodadi","Tawangsari","Trosobo","Wage","Bebekan","Geluran","Kalijaten","Ketegan","Ngelom","Sepanjang","Taman","Wonocolo"]],
           ["nama" =>  "Tanggulangin", "kelurahan" => ["Kalitengah","Kludan","Boro","Ngaban","Putat","Kedungbanteng","Banjarpanji","Banjarsari","Penatarsewu","SentulKalidawir","Gempolsari","Kedungbendo","Ketapang","Kalisampurno","Kedensari","Ketegan","Ganggang Panjang","Randegan"]],
           ["nama" =>  "Tarik", "kelurahan" => ["Balongmacekan","Gampingrowo","Gedangklutuk","Janti","Kalimati","Kedungbocok","Kedinding","Kemuning","Kendalsewu","Klantingsari","Kramattemanggung","Mergobener","Mergosari","Mindugading","Miriprowo","Sebani","Segodobancang","Singgogalih","Tarik"]],
           ["nama" =>  "Tulangan", "kelurahan" => ["Gelang","Grabangan","Grinting","Grogol","Janti","Jiken","Kajeksan","Kebaran","Kemantren","Kenongo","Kepatihan","Kepadangan","Kepuhkemiri","Kepunten","Medalem","Modong","Pangkemiri","Singopadu","Sudimoro","Tlasih","Tulangan"]],
           ["nama" =>  "Waru", "kelurahan" => ["Berbek","Bungurasih","Janti","Kedungrejo","Kepuhkiriman","Kureksari","Medaeng","Ngingas","Pepelegi","Tambakoso","Tambarejo","Tambaksawah","Tambaksumur","Tropodo","Wadungasri","Waru","Wedoro"]],
           ["nama" =>  "Wonoayu", "kelurahan" => ["Becirongengor","Candinegoro","Jimbarankulon","Jimbaranwetan","Karangpuri","Ketimang","Lambangan","Mojorangagung","Mulyodadi","Pagerngumbuk","Pilang","Plaosan","Ploso","Popoh","Sawocangkring","Semambung","Simoanginangin","Simoketawang","Sumberejo","Tanggul","Wonoayu","Wonokalang","Wonokasihan"]],
        ];
        for($i = 0; $i < count($data); $i++)
        {
            $kecamatan = Kecamatan::create([
                'nama' => $data[$i]['nama']
            ]);
            for($j = 0; $j < count($data[$i]['kelurahan']); $j++)
            {
                
                $kelurahan = Kelurahan::create([
                    'nama' => $data[$i]['kelurahan'][$j],
                    'kecamatan_id' => $kecamatan->id
                ]);
            }
        }
    }
}
