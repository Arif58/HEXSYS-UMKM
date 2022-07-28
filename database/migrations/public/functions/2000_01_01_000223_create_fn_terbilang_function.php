<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFnTerbilangFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
        CREATE OR REPLACE FUNCTION public.fn_terbilang(angka numeric)
        RETURNS character varying
        LANGUAGE plpgsql
        IMMUTABLE
        AS $$
        DECLARE
            kata varchar[] = array['satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];
            kalimat varchar = 'Out of range!';
        begin

            angka = abs(angka);

            if (angka < 12) then
                kalimat = kata[angka];
            elseif (angka < 20) then
                kalimat = concat(fn_terbilang(trunc(angka - 10)), ' belas ');
            elseif (angka < (10^2)) then
                kalimat = concat(fn_terbilang(trunc(angka / 10)), ' puluh ', fn_terbilang(angka % 10));
            elseif (angka < 200) then
                kalimat = concat(' seratus ', fn_terbilang(trunc(angka - (10^2))::numeric));
            elseif (angka < (10^3)) then
                kalimat = concat(fn_terbilang(trunc(angka / (10^2))::numeric), ' ratus ', fn_terbilang(angka % (10^2)::numeric));
            elseif (angka < 2000) then
                kalimat = concat(' seribu ', fn_terbilang(angka - (10^3)::numeric));
            elseif (angka < (10^6)) then
                kalimat = concat(fn_terbilang(trunc(angka / (10^3))::numeric), ' ribu ', fn_terbilang(angka % (10^3)::numeric));
            elseif (angka < (10^9)) then
                kalimat = concat(fn_terbilang(trunc(angka / (10^6))::numeric), ' juta ', fn_terbilang(angka % (10^6)::numeric));
            elseif (angka < (10^12)) then
                kalimat = concat(fn_terbilang(trunc(angka / (10^9))::numeric), ' milyar ', fn_terbilang(angka % (10^9)::numeric));
            elseif (angka < (10^15)) then
                kalimat = concat(fn_terbilang(trunc(angka / (10^12))::numeric), ' triliun ', fn_terbilang(angka % (10^12)::numeric));
            elseif (angka < (10^18)) then
                kalimat = concat(fn_terbilang(trunc(angka / (10^15))::numeric), ' kuadriliun ', fn_terbilang(angka % (10^15)::numeric));
            elseif (angka < (10^21)) then
                kalimat = concat(fn_terbilang(trunc(angka / (10^18))::numeric), ' kuantiliun ', fn_terbilang(angka % (10^18)::numeric));
            elseif (angka < (10^24)) then
                kalimat = concat(fn_terbilang(trunc(angka / (10^21))::numeric), ' sekstiliun ', fn_terbilang(angka % (10^21)::numeric));
            elseif (angka < (10^27)) then
                kalimat = concat(fn_terbilang(trunc(angka / (10^24))::numeric), ' septiliun ', fn_terbilang(angka % (10^24)::numeric));
            elseif (angka < (10^30)) then
                kalimat = concat(fn_terbilang(trunc(angka / (10^27))::numeric), ' oktiliun ', fn_terbilang(angka % (10^27)::numeric));
            elseif (angka < (10^33)) then
                kalimat = concat(fn_terbilang(trunc(angka / (10^30))::numeric), ' noniliun ', fn_terbilang(angka % (10^30)::numeric));
            elseif (angka < (10^36)) then
                kalimat = concat(fn_terbilang(trunc(angka / (10^33))::numeric), ' desiliun ', fn_terbilang(angka % (10^33)::numeric));
            end if;

        return trim(kalimat);

        end;
        $$
        ;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP FUNCTION IF EXISTS public.fn_terbilang(angka numeric);");
    }
}
