<?php
use Illuminate\Database\Seeder;
/**
 * Usage :
 * [1] $ composer dump-autoload -o
 * [2] $ php artisan db:seed --class=BantenprovZonaSeeder
 */
class BantenprovZonaSeeder extends Seeder
{
    /* text color */
    protected $RED     ="\033[0;31m";
    protected $CYAN    ="\033[0;36m";
    protected $YELLOW  ="\033[1;33m";
    protected $ORANGE  ="\033[0;33m";
    protected $PUR     ="\033[0;35m";
    protected $GRN     ="\e[32m";
    protected $WHI     ="\e[37m";
    protected $NC      ="\033[0m";
    /* File name */
    /* location : /databse/seeds/file_name.csv */
    protected $fileName = "BantenprovZonaSeeder.csv";
    /* text info : default (true) */
    protected $textInfo = true;
    /* model class */
    protected $model;
    /* __construct */
    public function __construct(){
        $this->model = new Bantenprov\Zona\Models\Bantenprov\Zona\Zona;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->insertData();
    }
    /* function insert data */
    protected function insertData()
    {
        /* silahkan di rubah sesuai kebutuhan */
        foreach($this->readCSV() as $data){

            
        	$this->model->create([
            	'user_id' => $data['user_id'],
				'nomor_un' => $data['nomor_un'],
				'sekolah_id' => $data['sekolah_id'],
                'zona_siswa' => $data['zona_siswa'],
                'zona_sekolah' => $data['zona_sekolah'],
                'lokasi_siswa' => $data['lokasi_siswa'],
                'lokasi_sekolah' => $data['lokasi_sekolah'],
                'nilai_zona' => $data['nilai_zona'],

        	]);
        

        }

        if($this->textInfo){                
            echo "============[DATA]============\n";
            $this->orangeText('user_id : ').$this->greenText($data['user_id']);
			echo"\n";
			$this->orangeText('nomor_un : ').$this->greenText($data['nomor_un']);
			echo"\n";
			$this->orangeText('sekolah_id : ').$this->greenText($data['sekolah_id']);
			echo"\n";
            $this->orangeText('zona_siswa : ').$this->greenText($data['zona_siswa']);
            echo"\n";
            $this->orangeText('zona_sekolah : ').$this->greenText($data['zona_sekolah']);
            echo"\n";
            $this->orangeText('lokasi_siswa : ').$this->greenText($data['lokasi_siswa']);
            echo"\n";
            $this->orangeText('lokasi_sekolah : ').$this->greenText($data['lokasi_sekolah']);
            echo"\n";
            $this->orangeText('nilai_zona : ').$this->greenText($data['nilai_zona']);
            echo"\n";

            
            
        
            echo "============[DATA]============\n\n";
        }

        $this->greenText('[ SEEDER DONE ]');
        echo"\n\n";
    }
    /* text color: orange */
    protected function orangeText($text)
    {
        printf($this->ORANGE.$text.$this->NC);
    }
    /* text color: green */
    protected function greenText($text)
    {
        printf($this->GRN.$text.$this->NC);
    }
    /* function read CSV file */
    protected function readCSV()
    {
        $file = fopen(database_path("seeds/".$this->fileName), "r");
        $all_data = array();
        $row = 1;
        while(($data = fgetcsv($file, 1000, ",")) !== FALSE){
            $all_data[] = ['user_id' => $data[0],
                           'nomor_un' => $data[1],
                           'sekolah_id' => $data[2],
                           'zona_siswa' => $data[3],
                           'zona_sekolah' => $data[4],
                           'lokasi_siswa' => $data[5],
                           'lokasi_sekolah' => $data[6],
                           'nilai_zona' => $data[7],
                          ];
        }
        fclose($file);
        return  $all_data;
    }
}
