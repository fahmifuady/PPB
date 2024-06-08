<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/[{name}]', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");

        // Render index view
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });


    $app->get('/mahasiswa/pembayaran', function(Request $request, Response $response){
        //disini dimasukan script sql
        $sql = "SELECT mahasiswa.nim, nama,
            CASE
                WHEN jk='L' THEN 'Laki-Laki'
                WHEN jk='P' THEN 'Perempuan'
            END as jenis_kelamin , umur, ifnull(semester,0) as semester, ifnull(jumlah,0) as jumlah_spp
            FROM mahasiswa LEFT JOIN spp_mahasiswa
            ON mahasiswa.nim = spp_mahasiswa.nim WHERE mahasiswa.nim<>0";

        $jk = $request->getQueryParam("jk");
        $umur = $request->getQueryParam("umur");

        if($jk<>null){
            $sql = $sql." AND jk='$jk'";
        };

        if($umur<>null){
            $sql = $sql." AND umur=$umur";
        };
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status"=>"success", "data"=>$result],200);
    });          

    $app->post('/mahasiswa/edit', function(Request $request, Response $response){
        $add_mahasiswa = $request->getParsedBody();
        $nim = $add_mahasiswa['nim'];
        $jk = $add_mahasiswa['jk'];
        $nama = $add_mahasiswa['nama'];
        $umur = $add_mahasiswa['umur'];
        //disini dimasukan script sql
        $sql = "INSERT INTO mahasiswa(nim, nama, jk, umur) VALUES
        ($nim, '$nama', '$jk', $umur)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $response->withJson(["status"=>"success", "data"=>"1"],200);
    });
      
    $app->put('/mahasiswa/edit', function(Request $request, Response $response){
        $add_mahasiswa = $request->getParsedBody();
        $nim = $add_mahasiswa['nim'];
        $jk = $add_mahasiswa['jk'];
        $nama = $add_mahasiswa['nama'];
        $umur = $add_mahasiswa['umur'];
        $textupdate= "";

        if($nama<>null){
            $textupdate = $textupdate.", nama='$nama'";
        };

        if($jk<>null){
            $textupdate = $textupdate.", jk='$jk'";
        };

        if($umur<>null){
            $textupdate = $textupdate.", umur=$umur";
        };

        //disini dimasukan script sql
        $sql = "UPDATE mahasiswa SET nim=$nim".$textupdate." WHERE nim=$nim";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $response->withJson(["status"=>"success", "data"=>"1"],200);
    });

    $app->delete('/mahasiswa/edit', function(Request $request, Response $response){
        $add_mahasiswa = $request->getParsedBody();
        $nim = $add_mahasiswa['nim'];
        //disini dimasukan script sql
        $sql = "DELETE FROM mahasiswa WHERE nim=$nim";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $response->withJson(["status"=>"success", "data"=>"1"],200);
    });
            
};