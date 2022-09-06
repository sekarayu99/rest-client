<?php 

use GuzzleHttp\Client;

class Mahasiswa_model extends CI_model 
{
    public function getAllMahasiswa()
    {
        // return $this->db->get('mahasiswa')->result_array();
        $client = new Client();

        $response = $client->request('GET', 'http://localhost/rest-api/see-rest-server/api/mahasiswa', [
            'auth' => ['admin','1234'],
            'query' =>[
                'X-API-KEY' =>'pie123',
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);
        return $result['data'];
    }

    public function getMahasiswaById($id)
    {
        // return $this->db->get_where('mahasiswa', ['id' => $id])->row_array();
        $client = new Client();

        $response = $client->request('GET', 'http://localhost/rest-api/see-rest-server/api/mahasiswa', [
            'auth' => ['admin','1234'],
            'query' =>[
                'X-API-KEY' =>'pie123',
                'id' => $id
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);
        return $result['data'][0];
    }


    public function tambahDataMahasiswa()
    {
        $data = [
            "nama" => $this->input->post('nama', true),
            "nrp" => $this->input->post('nrp', true),
            "email" => $this->input->post('email', true),
            "jurusan" => $this->input->post('jurusan', true)
        ];

        $this->db->insert('mahasiswa', $data);
    }

    public function hapusDataMahasiswa($id)
    {
        $client = new Client();

        $response = $client->request('DELETE', 'http://localhost/rest-api/see-rest-server/api/mahasiswa', [
            'form_params' => [
                'id' => $id,
                'X-API_KEY' => 'pie123'
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }

    
    public function ubahDataMahasiswa()
    {
        $data = [
            "nama" => $this->input->post('nama', true),
            "nrp" => $this->input->post('nrp', true),
            "email" => $this->input->post('email', true),
            "jurusan" => $this->input->post('jurusan', true)
        ];

        $this->db->where('id', $this->input->post('id'));
        $this->db->update('mahasiswa', $data);
    }

    public function cariDataMahasiswa()
    {
        $keyword = $this->input->post('keyword', true);
        $this->db->like('nama', $keyword);
        $this->db->or_like('jurusan', $keyword);
        $this->db->or_like('nrp', $keyword);
        $this->db->or_like('email', $keyword);
        return $this->db->get('mahasiswa')->result_array();
    }
}