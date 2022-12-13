<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Enlaces extends Controller
{
    /**
     * aboutUs permite mostrar la sección sobrenosotros
     *
     * @return \Illuminate\Http\Response
     */
    public function aboutUs()
    {
        return view("enlaces/sobrenosotros");
    }

    /**
     * aboutUs permite mostrar la sección politicaprivacidad
     *
     * @return \Illuminate\Http\Response
     */
    public function privacyPolicy()
    {
        return view("enlaces/politicaprivacidad");
    }

    /**
     * aboutUs permite mostrar la sección mapaweb
     *
     * @return \Illuminate\Http\Response
     */
    public function webMap()
    {
        return view("enlaces/mapaweb");
    }
}
