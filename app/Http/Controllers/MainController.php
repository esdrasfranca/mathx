<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function home()
    {
        session(['exercicios' => null]);
        return view('home');
    }

    public function gerarExercicios(Request $request)
    {
        // Form validation
        $request->validate([
            'check_sum' => 'required_without_all:check_subtraction,check_multiplication,check_division',
            'check_subtraction' => 'required_without_all:check_sum,check_multiplication,check_division',
            'check_multiplication' => 'required_without_all:check_sum,check_subtraction,check_division',
            'check_division' => 'required_without_all:check_sum,check_subtraction,check_multiplication',
            'number_one' => 'required|integer|min:0|max:999|lt:number_two',
            'number_two' => 'required|integer|min:0|max:999',
            'number_exercises' => 'required|integer|min:5|max:50',
        ]);

        $operacoes = [];
        if ($request->check_sum) $operacoes[] = 'soma';
        if ($request->check_subtraction) $operacoes[] = 'subtracao';
        if ($request->check_multiplication) $operacoes[] = 'multiplicacao';
        if ($request->check_division) $operacoes[] = 'divisao';

        $min = $request->number_one;
        $max = $request->number_two;
        $numero_exercicios = $request->number_exercises;

        // Gerar exercícios
        $exercicios = [];
        for ($i = 0; $i < $numero_exercicios; $i++) {
            $exercicios[] = $this->gerar($operacoes[array_rand($operacoes)], $min, $max, $i);
        }

        session(['exercicios' => $exercicios]);

        return view('operations', ['exercicios' => $exercicios]);
    }

    public function imprimirExercicios()
    {
        if (!session()->has('exercicios')) {
            return redirect('/');
        }

        $exercicios = session('exercicios');

        echo '<pre>';
        echo '<h1>Exercícios de Matemática (' . env('APP_NAME') . ')</h1>';
        echo '<hr>';

        foreach ($exercicios as $exercicio) {
            echo '<h2>Exercício ' . $exercicio['exercicio_numero'] . ': ' . $exercicio['exercicio'] . ' =</h2>';
        }

        echo '<hr>';
        foreach ($exercicios as $exercicio) {
            echo '<p>Resposta Exercício ' . $exercicio['exercicio_numero'] . ': ' . $exercicio['resposta'] . '</p>';
        }

        echo '</pre>';
    }

    public function exportarExercicios()
    {
        if (!session()->has('exercicios')) {
            return redirect('/');
        }

        $exercicios = session('exercicios');
        $filename = 'exercicios_' . env('APP_NAME') . '_' . date('YmdHis') . '.txt';

        $content = 'Exercícios de Matemática - ' . env('APP_NAME') . "\n";
        $content .= str_repeat('-', 50) . "\n\n";
        foreach ($exercicios as $exercicio) {
            $content .= 'Exercício ' . $exercicio['exercicio_numero'] . ' > ' . $exercicio['exercicio'] . " = \n";
        }

        $content .= str_repeat('-', 50) . "\n\n";
        $content .= "Respostas\n\n";
        foreach ($exercicios as $exercicio) {
            $content .= $exercicio['exercicio_numero'] . ' > ' . $exercicio['resposta'] . "\n";
        }

        return response($content)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Content-Length', strlen($content));
    }

    private function gerar($operacao, $min, $max, $index): array
    {
        $numero1 = rand($min, $max);
        $numero2 = rand($min, $max);

        $exercicio = '';
        $resposta = '';

        switch ($operacao) {
            case 'soma':
                $exercicio = $numero1 . ' + ' . $numero2;
                $resposta = $numero1 + $numero2;
                break;

            case 'subtracao':
                $exercicio = $numero1 . ' - ' . $numero2;
                $resposta = $numero1 - $numero2;
                break;

            case 'multiplicacao':
                $exercicio = $numero1 . ' x ' . $numero2;
                $resposta = $numero1 * $numero2;
                break;

            case 'divisao':
                if ($numero2 == 0) $numero2 = 1;
                $exercicio = $numero1 . ' ÷ ' . $numero2;
                $resposta = $numero1 / $numero2;
                break;
        }

        return [
            'exercicio_numero' => str_pad(($index + 1), 2, '0', STR_PAD_LEFT),
            'exercicio' => $exercicio,
            'resposta' => $resposta,
            'operacao' => $operacao,
        ];
    }
}
