<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class bancos extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bancos')->insert([
                [
                    'clave' => '002',
                    'nombre' => 'BANAMEX',
                    'razon_social' => 'Banco Nacional de México, S.A., Institución de Banca Múltiple, Grupo Financiero Banamex',
                ],
                [
                    'clave' => '006',
                    'nombre' => 'BANCOMEXT',
                    'razon_social' => 'Banco Nacional de Comercio Exterior, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo',
                ],
                [
                    'clave' => '009',
                    'nombre' => 'BANOBRAS',
                    'razon_social' => 'Banco Nacional de Obras y Servicios Públicos, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo',
                ],
                [
                    'clave' => '012',
                    'nombre' => 'BBVA BANCOMER',
                    'razon_social' => 'BBVA Bancomer, S.A., Institución de Banca Múltiple, Grupo Financiero BBVA Bancomer',
                ],
                [
                    'clave' => '014',
                    'nombre' => 'SANTANDER',
                    'razon_social' => 'Banco Santander (México), S.A., Institución de Banca Múltiple, Grupo Financiero Santander',
                ],
                [
                    'clave' => '019',
                    'nombre' => 'BANJERCITO',
                    'razon_social' => 'Banco Nacional del Ejército, Fuerza Aérea y Armada, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo',
                ],
                [
                    'clave' => '021',
                    'nombre' => 'HSBC',
                    'razon_social' => 'HSBC México, S.A., institución De Banca Múltiple, Grupo Financiero HSBC',
                ],
                [
                    'clave' => '030',
                    'nombre' => 'BAJIO',
                    'razon_social' => 'Banco del Bajío, S.A., Institución de Banca Múltiple',
                ],
                [
                    'clave' => '032',
                    'nombre' => 'IXE',
                    'razon_social' => 'IXE Banco, S.A., Institución de Banca Múltiple, IXE Grupo Financiero',
                ],
                [
                    'clave' => '036',
                    'nombre' => 'INBURSA',
                    'razon_social' => 'Banco Inbursa, S.A., Institución de Banca Múltiple, Grupo Financiero Inbursa',
                ],
                [
                    'clave' => '037',
                    'nombre' => 'INTERACCIONES',
                    'razon_social' => 'Banco Interacciones, S.A., Institución de Banca Múltiple',
                ],
                [
                    'clave' => '042',
                    'nombre' => 'MIFEL',
                    'razon_social' => 'Banca Mifel, S.A., Institución de Banca Múltiple, Grupo Financiero Mifel',
                ],
                [
                    'clave' => '044',
                    'nombre' => 'SCOTIABANK',
                    'razon_social' => 'Scotiabank Inverlat, S.A.',
                ],
                [
                    'clave' => '058',
                    'nombre' => 'BANREGIO',
                    'razon_social' => 'Banco Regional de Monterrey, S.A., Institución de Banca Múltiple, Banregio Grupo Financiero',
                ],
                [
                    'clave' => '059',
                    'nombre' => 'INVEX',
                    'razon_social' => 'Banco Invex, S.A., Institución de Banca Múltiple, Invex Grupo Financiero',
                ],
                [
                    'clave' => '060',
                    'nombre' => 'BANSI',
                    'razon_social' => 'Bansi, S.A., Institución de Banca Múltiple',
                ],
                [
                    'clave' => '062',
                    'nombre' => 'AFIRME',
                    'razon_social' => 'Banca Afirme, S.A., Institución de Banca Múltiple',
                ],
                [
                    'clave' => '072',
                    'nombre' => 'BANORTE',
                    'razon_social' => 'Banco Mercantil del Norte, S.A., Institución de Banca Múltiple, Grupo Financiero Banorte',
                ],
                [
                    'clave' => '102',
                    'nombre' => 'THE ROYAL BANK',
                    'razon_social' => 'The Royal Bank of Scotland México, S.A., Institución de Banca Múltiple',
                ],
                [
                    'clave' => '103',
                    'nombre' => 'AMERICAN EXPRESS',
                    'razon_social' => 'American Express Bank (México), S.A., Institución de Banca Múltiple',
                ],
                [
                    'clave' => '106',
                    'nombre' => 'BAMSA',
                    'razon_social' => 'Bank of America México, S.A., Institución de Banca Múltiple, Grupo Financiero Bank of America',
                ],
                [
                    'clave' => '108',
                    'nombre' => 'TOKYO',
                    'razon_social' => 'Bank of Tokyo-Mitsubishi UFJ (México), S.A.',
                ],
                [
                    'clave' => '110',
                    'nombre' => 'JP MORGAN',
                    'razon_social' => 'Banco J.P. Morgan, S.A., Institución de Banca Múltiple, J.P. Morgan Grupo Financiero',
                ],
                [
                    'clave' => '112',
                    'nombre' => 'BMONEX',
                    'razon_social' => 'Banco Monex, S.A., Institución de Banca Múltiple',
                ],
                [
                    'clave' => '113',
                    'nombre' => 'VE POR MAS',
                    'razon_social' => 'Banco Ve Por Mas, S.A. Institución de Banca Múltiple',
                ],
                [
                    'clave' => '116',
                    'nombre' => 'ING',
                    'razon_social' => 'ING Bank (México), S.A., Institución de Banca Múltiple, ING Grupo Financiero',
                ],
                [
                    'clave' => '124',
                    'nombre' => 'DEUTSCHE',
                    'razon_social' => 'Deutsche Bank México, S.A., Institución de Banca Múltiple',
                ],
                [
                    'clave' => '126',
                    'nombre' => 'CREDIT SUISSE',
                    'razon_social' => 'Banco Credit Suisse (México), S.A. Institución de Banca Múltiple, Grupo Financiero Credit Suisse (México)',
                ],
                [
                    'clave' => '127',
                    'nombre' => 'AZTECA',
                    'razon_social' => 'Banco Azteca, S.A. Institución de Banca Múltiple.',
                ],
                [
                    'clave' => '128',
                    'nombre' => 'AUTOFIN',
                    'razon_social' => 'Banco Autofin México, S.A. Institución de Banca Múltiple',
                ],
                [
                    'clave' => '129',
                    'nombre' => 'BARCLAYS',
                    'razon_social' => 'Barclays Bank México, S.A., Institución de Banca Múltiple, Grupo Financiero Barclays México',
                ],
                [
                    'clave' => '130',
                    'nombre' => 'COMPARTAMOS',
                    'razon_social' => 'Banco Compartamos, S.A., Institución de Banca Múltiple',
                ],
                [
                    'clave' => '131',
                    'nombre' => 'BANCO FAMSA',
                    'razon_social' => 'Banco Ahorro Famsa, S.A., Institución de Banca Múltiple',
                ],
                [
                    'clave' => '132',
                    'nombre' => 'BMULTIVA',
                    'razon_social' => 'Banco Multiva, S.A., Institución de Banca Múltiple, Multivalores Grupo Financiero',
                ],
                [
                    'clave' => '133',
                    'nombre' => 'ACTINVER',
                    'razon_social' => 'Banco Actinver, S.A. Institución de Banca Múltiple, Grupo Financiero Actinver',
                ],
                [
                    'clave' => '134',
                    'nombre' => 'WAL-MART',
                    'razon_social' => 'Banco Wal-Mart de México Adelante, S.A., Institución de Banca Múltiple',
                ],
                [
                    'clave' => '135',
                    'nombre' => 'NAFIN',
                    'razon_social' => 'Nacional Financiera, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo',
                ],
                [
                    'clave' => '136',
                    'nombre' => 'INTERBANCO',
                    'razon_social' => 'Inter Banco, S.A. Institución de Banca Múltiple',
                ],
                [
                    'clave' => '137',
                    'nombre' => 'BANCOPPEL',
                    'razon_social' => 'BanCoppel, S.A., Institución de Banca Múltiple',
                ],
                [
                    'clave' => '138',
                    'nombre' => 'ABC CAPITAL',
                    'razon_social' => 'ABC Capital, S.A., Institución de Banca Múltiple',
                ],
                [
                    'clave' => '139',
                    'nombre' => 'UBS BANK',
                    'razon_social' => 'UBS Bank México, S.A., Institución de Banca Múltiple, UBS Grupo Financiero',
                ],
                [
                    'clave' => '140',
                    'nombre' => 'CONSUBANCO',
                    'razon_social' => 'Consubanco, S.A. Institución de Banca Múltiple',
                ],
                [
                    'clave' => '141',
                    'nombre' => 'VOLKSWAGEN',
                    'razon_social' => 'Volkswagen Bank, S.A., Institución de Banca Múltiple',
                ],
                [
                    'clave' => '143',
                    'nombre' => 'CIBANCO',
                    'razon_social' => 'CIBanco, S.A.',
                ],
                [
                    'clave' => '145',
                    'nombre' => 'BBASE',
                    'razon_social' => 'Banco Base, S.A., Institución de Banca Múltiple',
                ],
                [
                    'clave' => '166',
                    'nombre' => 'BANSEFI',
                    'razon_social' => 'Banco del Ahorro Nacional y Servicios Financieros, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo',
                ],
                [
                    'clave' => '168',
                    'nombre' => 'HIPOTECARIA FEDERAL',
                    'razon_social' => 'Sociedad Hipotecaria Federal, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo',
                ],
                [
                    'clave' => '600',
                    'nombre' => 'MONEXCB',
                    'razon_social' => 'Monex Casa de Bolsa, S.A. de C.V. Monex Grupo Financiero',
                ],
                [
                    'clave' => '601',
                    'nombre' => 'GBM',
                    'razon_social' => 'GBM Grupo Bursátil Mexicano, S.A. de C.V. Casa de Bolsa',
                ],
                [
                    'clave' => '602',
                    'nombre' => 'MASARI',
                    'razon_social' => 'Masari Casa de Bolsa, S.A.',
                ],
                [
                    'clave' => '605',
                    'nombre' => 'VALUE',
                    'razon_social' => 'Value, S.A. de C.V. Casa de Bolsa',
                ],
                [
                    'clave' => '606',
                    'nombre' => 'ESTRUCTURADORES',
                    'razon_social' => 'Estructuradores del Mercado de Valores Casa de Bolsa, S.A. de C.V.',
                ],
                [
                    'clave' => '607',
                    'nombre' => 'TIBER',
                    'razon_social' => 'Casa de Cambio Tiber, S.A. de C.V.',
                ],
                [
                    'clave' => '608',
                    'nombre' => 'VECTOR',
                    'razon_social' => 'Vector Casa de Bolsa, S.A. de C.V.',
                ],
                [
                    'clave' => '610',
                    'nombre' => 'B&B',
                    'razon_social' => 'B y B, Casa de Cambio, S.A. de C.V.',
                ],
                [
                    'clave' => '614',
                    'nombre' => 'ACCIVAL',
                    'razon_social' => 'Acciones y Valores Banamex, S.A. de C.V., Casa de Bolsa',
                ],
                [
                    'clave' => '615',
                    'nombre' => 'MERRILL LYNCH',
                    'razon_social' => 'Merrill Lynch México, S.A. de C.V. Casa de Bolsa',
                ],
                [
                    'clave' => '616',
                    'nombre' => 'FINAMEX',
                    'razon_social' => 'Casa de Bolsa Finamex, S.A. de C.V.',
                ],
                [
                    'clave' => '617',
                    'nombre' => 'VALMEX',
                    'razon_social' => 'Valores Mexicanos Casa de Bolsa, S.A. de C.V.',
                ],
                [
                    'clave' => '618',
                    'nombre' => 'UNICA',
                    'razon_social' => 'Unica Casa de Cambio, S.A. de C.V.',
                ],
                [
                    'clave' => '619',
                    'nombre' => 'MAPFRE',
                    'razon_social' => 'MAPFRE Tepeyac, S.A.',
                ],
                [
                    'clave' => '620',
                    'nombre' => 'PROFUTURO',
                    'razon_social' => 'Profuturo G.N.P., S.A. de C.V., Afore',
                ],
                [
                    'clave' => '621',
                    'nombre' => 'CB ACTINVER',
                    'razon_social' => 'Actinver Casa de Bolsa, S.A. de C.V.',
                ],
                [
                    'clave' => '622',
                    'nombre' => 'OACTIN',
                    'razon_social' => 'OPERADORA ACTINVER, S.A. DE C.V.',
                ],
                [
                    'clave' => '623',
                    'nombre' => 'SKANDIA',
                    'razon_social' => 'Skandia Vida, S.A. de C.V.',
                ],
                [
                    'clave' => '626',
                    'nombre' => 'CBDEUTSCHE',
                    'razon_social' => 'Deutsche Securities, S.A. de C.V. CASA DE BOLSA',
                ],
                [
                    'clave' => '627',
                    'nombre' => 'ZURICH',
                    'razon_social' => 'Zurich Compañía de Seguros, S.A.',
                ],
                [
                    'clave' => '628',
                    'nombre' => 'ZURICHVI',
                    'razon_social' => 'Zurich Vida, Compañía de Seguros, S.A.',
                ],
                [
                    'clave' => '629',
                    'nombre' => 'SU CASITA',
                    'razon_social' => 'Hipotecaria Su Casita, S.A. de C.V. SOFOM ENR',
                ],
                [
                    'clave' => '630',
                    'nombre' => 'CB INTERCAM',
                    'razon_social' => 'Intercam Casa de Bolsa, S.A. de C.V.',
                ],
                [
                    'clave' => '631',
                    'nombre' => 'CI BOLSA',
                    'razon_social' => 'CI Casa de Bolsa, S.A. de C.V.',
                ],
                [
                    'clave' => '632',
                    'nombre' => 'BULLTICK CB',
                    'razon_social' => 'Bulltick Casa de Bolsa, S.A., de C.V.',
                ],
                [
                    'clave' => '633',
                    'nombre' => 'STERLING',
                    'razon_social' => 'Sterling Casa de Cambio, S.A. de C.V.',
                ],
                [
                    'clave' => '634',
                    'nombre' => 'FINCOMUN',
                    'razon_social' => 'Fincomún, Servicios Financieros Comunitarios, S.A. de C.V.',
                ],
                [
                    'clave' => '636',
                    'nombre' => 'HDI SEGUROS',
                    'razon_social' => 'HDI Seguros, S.A. de C.V.',
                ],
                [
                    'clave' => '637',
                    'nombre' => 'ORDER',
                    'razon_social' => 'Order Express Casa de Cambio, S.A. de C.V',
                ],
                [
                    'clave' => '638',
                    'nombre' => 'AKALA',
                    'razon_social' => 'Akala, S.A. de C.V., Sociedad Financiera Popular',
                ],
                [
                    'clave' => '640',
                    'nombre' => 'CB JPMORGAN',
                    'razon_social' => 'J.P. Morgan Casa de Bolsa, S.A. de C.V. J.P. Morgan Grupo Financiero',
                ],
                [
                    'clave' => '642',
                    'nombre' => 'REFORMA',
                    'razon_social' => 'Operadora de Recursos Reforma, S.A. de C.V., S.F.P.',
                ],
                [
                    'clave' => '646',
                    'nombre' => 'STP',
                    'razon_social' => 'Sistema de Transferencias y Pagos STP, S.A. de C.V.SOFOM ENR',
                ],
                [
                    'clave' => '647',
                    'nombre' => 'TELECOMM',
                    'razon_social' => 'Telecomunicaciones de México',
                ],
                [
                    'clave' => '648',
                    'nombre' => 'EVERCORE',
                    'razon_social' => 'Evercore Casa de Bolsa, S.A. de C.V.',
                ],
                [
                    'clave' => '649',
                    'nombre' => 'SKANDIA',
                    'razon_social' => 'Skandia Operadora de Fondos, S.A. de C.V.',
                ],
                [
                    'clave' => '651',
                    'nombre' => 'SEGMTY',
                    'razon_social' => 'Seguros Monterrey New York Life, S.A de C.V',
                ],
                [
                    'clave' => '652',
                    'nombre' => 'ASEA',
                    'razon_social' => 'Solución Asea, S.A. de C.V., Sociedad Financiera Popular',
                ],
                [
                    'clave' => '653',
                    'nombre' => 'KUSPIT',
                    'razon_social' => 'Kuspit Casa de Bolsa, S.A. de C.V.',
                ],
                [
                    'clave' => '655',
                    'nombre' => 'SOFIEXPRESS',
                    'razon_social' => 'J.P. SOFIEXPRESS, S.A. de C.V., S.F.P.',
                ],
                [
                    'clave' => '656',
                    'nombre' => 'UNAGRA',
                    'razon_social' => 'UNAGRA, S.A. de C.V., S.F.P.',
                ],
                [
                    'clave' => '659',
                    'nombre' => 'OPCIONES EMPRESARIALES DEL NOROESTE',
                    'razon_social' => 'OPCIONES EMPRESARIALES DEL NORESTE, S.A. DE C.V., S.F.P.',
                ],
                [
                    'clave' => '901',
                    'nombre' => 'CLS',
                    'razon_social' => 'Cls Bank International',
                ],
                [
                    'clave' => '902',
                    'nombre' => 'INDEVAL',
                    'razon_social' => 'SD. Indeval, S.A. de C.V.',
                ],
                [
                    'clave' => '670',
                    'nombre' => 'LIBERTAD',
                    'razon_social' => 'Libertad Servicios Financieros, S.A. De C.V.',
                ],
                [
                    'clave' => '999',
                    'nombre' => 'N/A',
                    'razon_social' => '',
                ],
        ]);
    }
}
