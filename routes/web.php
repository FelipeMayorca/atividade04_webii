<?php

use Illuminate\Support\Facades\Route;
use \Illuminate\Http\Request;
use Illuminate\Support\Arr;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::prefix('/aluno')->group(function() {

    Route::get('/', function () {

        $dados = array(
            "Thiago",
            "Paula",
            "Marcelo",
            "Pedro",
            "Ana"
        );

        $alunos = "<ul>";

        foreach ($dados as $nome) {
            $alunos .= "<li>$nome</li>";
        }

        $alunos .= "</ul>";

        return $alunos;

    })->name('aluno');


    Route::get('/limite/{valor}', function($valor) {

        $dados = array(
            "Thiago",
            "Paula",
            "Marcelo",
            "Pedro",
            "Ana"
        );

        $alunos = "<ul>";

        if ($valor <= count($dados)) {
            $cont = 0;
            foreach ($dados as $nome) {
                $alunos .= "<li>$nome</li>";
                $cont++;
                if ($cont >= $valor) break;
            }
        } else {
            $alunos = $alunos."<li>Limite = ".count($dados)."</li>";
        }

        $alunos .= "</ul>";
        return $alunos;

    })->name('aluno.limite')->where('valor', '[0-9]+');


    Route::get('/matricula/{valor}', function($valor) {

        $dados = array(
            "Thiago",
            "Paula",
            "Marcelo",
            "Pedro",
            "Ana"
        );

        $aluno = "<ul>";

        if($valor <= count($dados)){
            $cont = 0;
            foreach($dados as $nome){
                if($cont == $valor - 1) {
                    $aluno .= $valor." • ".$nome;
                    break;
                }
                $cont++;
            }
        
        }else {
            $aluno = $aluno."<li>Aluno não encontrado</li>";
        }

        $aluno .= "</ul>";
        return $aluno;

        
    })->name('aluno.matricula')->where('valor', '[0-9]+');

    Route::get('/nome/{name}', function($name) {

        $dados = array(
            "Thiago",
            "Paula",
            "Marcelo",
            "Pedro",
            "Ana"
        );

        $aluno = "<ul>";
        $achou = 0;

        foreach($dados as $nome){
            if(!strcmp($name, $nome)) {
                $aluno .= $nome;
                $achou = 1;
            }
        }

        if($achou == 0) {
            $aluno = $aluno."<li>Aluno não encontrado</li>";
        }


        $aluno .= "</ul>";
        return $aluno;

    })->name('aluno.nome')->where('name', '[A-Za-z]+');

});

Route::prefix('/nota')->group(function() {

    Route::get('/', function() {

        $dados = array(
            array("matricula" => 1, "nome" => "Thiago", "nota" => 7),
            array("matricula" => 2, "nome" => "Paula", "nota" => 8),
            array("matricula" => 3, "nome" => "Marcelo", "nota" => 5),
            array("matricula" => 4, "nome" => "Pedro", "nota" => 6),
            array("matricula" => 5, "nome" => "Ana", "nota" => 5)
        );

        $tabela = '<table>';
        $tabela .= '<tr><th>Matricula</th><th>Nome</th><th>Nota</th></tr>';

        foreach ($dados as $linha) {
            $tabela .= '<tr>';
            foreach ($linha as $valor) {
                $tabela .= '<td>' . $valor . '</td>';
            }
            $tabela .= '</tr>';
        }
        
        $tabela .= '</table>';

        return $tabela;

    })->name('nota');

    Route::get('/limite/{valor}', function($valor) {

        $dados = array(
            array("matricula" => 1, "nome" => "Thiago", "nota" => 7),
            array("matricula" => 2, "nome" => "Paula", "nota" => 8),
            array("matricula" => 3, "nome" => "Marcelo", "nota" => 5),
            array("matricula" => 4, "nome" => "Pedro", "nota" => 6),
            array("matricula" => 5, "nome" => "Ana", "nota" => 5)
        );

        if ($valor <= count($dados)) {

            $tabela = '<table>';
            $tabela .= '<tr><th>Matricula</th><th>Nome</th><th>Nota</th></tr>';

            foreach (array_slice($dados, 0, $valor) as $linha) {
                $tabela .= '<tr>';
                foreach ($linha as $valor) {
                    $tabela .= '<td>' . $valor . '</td>';
                }
                $tabela .= '</tr>';
            }

        } else {
            $tabela = "<h2>Tamanho Máximo = " .count($dados)."</h2>";
        }

        $tabela .= '</table>';

        return $tabela;

    })->name('nota.limite')->where('valor', '[0-9]+');

    Route::get('/lancar/{nota}/{matricula}/{nome?}', function($nota, $matricula, $nome = null) {

        $dados = array(
            array("matricula" => 1, "nome" => "Thiago", "nota" => 7),
            array("matricula" => 2, "nome" => "Paula", "nota" => 8),
            array("matricula" => 3, "nome" => "Marcelo", "nota" => 5),
            array("matricula" => 4, "nome" => "Pedro", "nota" => 6),
            array("matricula" => 5, "nome" => "Ana", "nota" => 5)
        );

        $flag = 0;

        if ($nome != null) {

            foreach ($dados as $chave => $valor) {
                if (strcmp($valor['nome'],$nome) === 0) {
                    $dados[$chave]['nota'] = $nota;
                    $flag = 1;
                    break;
                }
            }

        } else {

            foreach ($dados as $chave => $valor) {
                if ($valor['matricula'] == $matricula) {
                    $dados[$chave]['nota'] = $nota;
                    $flag = 1;
                    break;
                }
            }
        }

        if ($flag == 0) {
            return '<li>NÃO ENCONTRADO!</li>';
        }

        $tabela = '<table>';
        $tabela .= '<tr><th>Matricula</th><th>Nome</th><th>Nota</th></tr>';

        foreach ($dados as $linha) {
            $tabela .= '<tr>';
            foreach ($linha as $valor) {
                $tabela .= '<td>' . $valor . '</td>';
            }
            $tabela .= '</tr>';
        }
        
        $tabela .= '</table>';

        return $tabela;

    })->name('nota.lancar')->where('nota', '[0-9]+')->where('matricula', '[0-9]+');

    Route::get('/conceito/{valorA}/{valorB}/{valorC}', function($valorA, $valorB, $valorC) {

        $dados = array(
            array("matricula" => 1, "nome" => "Thiago", "nota" => 7),
            array("matricula" => 2, "nome" => "Paula", "nota" => 8),
            array("matricula" => 3, "nome" => "Marcelo", "nota" => 5),
            array("matricula" => 4, "nome" => "Pedro", "nota" => 6),
            array("matricula" => 5, "nome" => "Ana", "nota" => 5)
        );

        foreach ($dados as $chave => $valor) {
            if ($valor['nota'] >= $valorA) {
                $dados[$chave]['nota'] = "A";
            } 
            else if ($valor['nota'] >= $valorB) {
                $dados[$chave]['nota'] = "B";
            } 
            else if($valor['nota'] >= $valorC) {
                $dados[$chave]['nota'] = "C";
            } 
            else {
                $dados[$chave]['nota'] = "D";
            }
        }

        $tabela = '<table>';
        $tabela .= '<tr><th>Matricula</th><th>Nome</th><th>Nota</th></tr>';

        foreach ($dados as $linha) {
            $tabela .= '<tr>';
            foreach ($linha as $valor) {
                $tabela .= '<td>' . $valor . '</td>';
            }
            $tabela .= '</tr>';
        }
        
        $tabela .= '</table>';

        return $tabela;

    })->name('nota.conceito')
      ->where('valorA', '[0-9]+')
      ->where('valorB', '[0-9]+')
      ->where('valorC', '[0-9]+');

    Route::post('/conceito', function(Request $request) {

        $dados = array(
            array("matricula" => 1, "nome" => "Thiago", "nota" => 7),
            array("matricula" => 2, "nome" => "Paula", "nota" => 8),
            array("matricula" => 3, "nome" => "Marcelo", "nota" => 5),
            array("matricula" => 4, "nome" => "Pedro", "nota" => 6),
            array("matricula" => 5, "nome" => "Ana", "nota" => 5)
        );

        foreach ($dados as $chave => $valor) {
            if ($valor['nota'] > $request->input('A')) {
                $dados[$chave]['nota'] = "A";
            } 
            else if ($valor['nota'] > $request->input('B')) {
                $dados[$chave]['nota'] = "B";
            } 
            else if($valor['nota'] >= $request->input('C')) {
                $dados[$chave]['nota'] = "C";
            } 
            else {
                $dados[$chave]['nota'] = "D";
            }
        }

        $tabela = '<table>';
        $tabela .= '<tr><th>Matricula</th><th>Nome</th><th>Nota</th></tr>';

        foreach ($dados as $linha) {
            $tabela .= '<tr>';
            foreach ($linha as $valor) {
                $tabela .= '<td>' . $valor . '</td>';
            }
            $tabela .= '</tr>';
        }
        
        $tabela .= '</table>';

        return $tabela;

    });

});

