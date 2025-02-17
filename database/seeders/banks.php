<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class banks extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('banks')->insert([
                [
                    'clave' => '002',
                    'name' => 'BANAMEX',
                    'razon_social' => 'Banco Nacional de México, S.A., Institución de Banca Múltiple, Grupo Financiero Banamex',
                ],
                [
                    'clave' => '006',
                    'name' => 'BANCOMEXT',
                    'razon_social' => 'Banco Nacional de Comercio Exterior, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo',
                ],
                [
                    'clave' => '009',
                    'name' => 'BANOBRAS',
                    'razon_social' => 'Banco Nacional de Obras y Servicios Públicos, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo',
                ],
                [
                    'clave' => '012',
                    'name' => 'BBVA BANCOMER',
                    'razon_social' => 'BBVA Bancomer, S.A., Institución de Banca Múltiple, Grupo Financiero BBVA Bancomer',
                ],
                [
                    'clave' => '014',
                    'name' => 'SANTANDER',
                    'razon_social' => 'Banco Santander (México), S.A., Institución de Banca Múltiple, Grupo Financiero Santander',
                ],
                [
                    'clave' => '019',
                    'name' => 'BANJERCITO',
                    'razon_social' => 'Banco Nacional del Ejército, Fuerza Aérea y Armada, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo',
                ],
                [
                    'clave' => '021',
                    'name' => 'HSBC',
                    'razon_social' => 'HSBC México, S.A., institución De Banca Múltiple, Grupo Financiero HSBC',
                ],
                [
                    'clave' => '030',
                    'name' => 'BAJIO',
                    'razon_social' => 'Banco del Bajío, S.A., Institución de Banca Múltiple',
                ],
                [
                    'clave' => '032',
                    'name' => 'IXE',
                    'razon_social' => 'IXE Banco, S.A., Institución de Banca Múltiple, IXE Grupo Financiero',
                ],
                [
                    'clave' => '036',
                    'name' => 'INBURSA',
                    'razon_social' => 'Banco Inbursa, S.A., Institución de Banca Múltiple, Grupo Financiero Inbursa',
                ],
                [
                    'clave' => '037',
                    'name' => 'INTERACCIONES',
                    'razon_social' => 'Banco Interacciones, S.A., Institución de Banca Múltiple',
                ],
                [
                    'clave' => '042',
                    'name' => 'MIFEL',
                    'razon_social' => 'Banca Mifel, S.A., Institución de Banca Múltiple, Grupo Financiero Mifel',
                ],
                [
                    'clave' => '044',
                    'name' => 'SCOTIABANK',
                    'razon_social' => 'Scotiabank Inverlat, S.A.',
                ],
                [
                    'clave' => '058',
                    'name' => 'BANREGIO',
                    'razon_social' => 'Banco Regional de Monterrey, S.A., Institución de Banca Múltiple, Banregio Grupo Financiero',
                ],
                [
                    'clave' => '059',
                    'name' => 'INVEX',
                    'razon_social' => 'Banco Invex, S.A., Institución de Banca Múltiple, Invex Grupo Financiero',
                ],
                [
                    'clave' => '060',
                    'name' => 'BANSI',
                    'razon_social' => 'Bansi, S.A., Institución de Banca Múltiple',
                ],
                [
                    'clave' => '062',
                    'name' => 'AFIRME',
                    'razon_social' => 'Banca Afirme, S.A., Institución de Banca Múltiple',
                ],
                [
                    'clave' => '072',
                    'name' => 'BANORTE',
                    'razon_social' => 'Banco Mercantil del Norte, S.A., Institución de Banca Múltiple, Grupo Financiero Banorte',
                ],
                [
                    'clave' => '102',
                    'name' => 'THE ROYAL BANK',
                    'razon_social' => 'The Royal Bank of Scotland México, S.A., Institución de Banca Múltiple',
                ],
                [
                    'clave' => '103',
                    'name' => 'AMERICAN EXPRESS',
                    'razon_social' => 'American Express Bank (México), S.A., Institución de Banca Múltiple',
                ],
                [
                    'clave' => '106',
                    'name' => 'BAMSA',
                    'razon_social' => 'Bank of America México, S.A., Institución de Banca Múltiple, Grupo Financiero Bank of America',
                ],
                [
                    'clave' => '108',
                    'name' => 'TOKYO',
                    'razon_social' => 'Bank of Tokyo-Mitsubishi UFJ (México), S.A.',
                ],
                [
                    'clave' => '110',
                    'name' => 'JP MORGAN',
                    'razon_social' => 'Banco J.P. Morgan, S.A., Institución de Banca Múltiple, J.P. Morgan Grupo Financiero',
                ],
                [
                    'clave' => '112',
                    'name' => 'BMONEX',
                    'razon_social' => 'Banco Monex, S.A., Institución de Banca Múltiple',
                ],
                [
                    'clave' => '113',
                    'name' => 'VE POR MAS',
                    'razon_social' => 'Banco Ve Por Mas, S.A. Institución de Banca Múltiple',
                ],
                [
                    'clave' => '116',
                    'name' => 'ING',
                    'razon_social' => 'ING Bank (México), S.A., Institución de Banca Múltiple, ING Grupo Financiero',
                ],
                [
                    'clave' => '124',
                    'name' => 'DEUTSCHE',
                    'razon_social' => 'Deutsche Bank México, S.A., Institución de Banca Múltiple',
                ],
                [
                    'clave' => '126',
                    'name' => 'CREDIT SUISSE',
                    'razon_social' => 'Banco Credit Suisse (México), S.A. Institución de Banca Múltiple, Grupo Financiero Credit Suisse (México)',
                ],
                [
                    'clave' => '127',
                    'name' => 'AZTECA',
                    'razon_social' => 'Banco Azteca, S.A. Institución de Banca Múltiple.',
                ],
                [
                    'clave' => '128',
                    'name' => 'AUTOFIN',
                    'razon_social' => 'Banco Autofin México, S.A. Institución de Banca Múltiple',
                ],
                [
                    'clave' => '129',
                    'name' => 'BARCLAYS',
                    'razon_social' => 'Barclays Bank México, S.A., Institución de Banca Múltiple, Grupo Financiero Barclays México',
                ],
                [
                    'clave' => '130',
                    'name' => 'COMPARTAMOS',
                    'razon_social' => 'Banco Compartamos, S.A., Institución de Banca Múltiple',
                ],
                [
                    'clave' => '131',
                    'name' => 'BANCO FAMSA',
                    'razon_social' => 'Banco Ahorro Famsa, S.A., Institución de Banca Múltiple',
                ],
                [
                    'clave' => '132',
                    'name' => 'BMULTIVA',
                    'razon_social' => 'Banco Multiva, S.A., Institución de Banca Múltiple, Multivalores Grupo Financiero',
                ],
                [
                    'clave' => '133',
                    'name' => 'ACTINVER',
                    'razon_social' => 'Banco Actinver, S.A. Institución de Banca Múltiple, Grupo Financiero Actinver',
                ],
                [
                    'clave' => '134',
                    'name' => 'WAL-MART',
                    'razon_social' => 'Banco Wal-Mart de México Adelante, S.A., Institución de Banca Múltiple',
                ],
                [
                    'clave' => '135',
                    'name' => 'NAFIN',
                    'razon_social' => 'Nacional Financiera, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo',
                ],
                [
                    'clave' => '136',
                    'name' => 'INTERBANCO',
                    'razon_social' => 'Inter Banco, S.A. Institución de Banca Múltiple',
                ],
                [
                    'clave' => '137',
                    'name' => 'BANCOPPEL',
                    'razon_social' => 'BanCoppel, S.A., Institución de Banca Múltiple',
                ],
                [
                    'clave' => '138',
                    'name' => 'ABC CAPITAL',
                    'razon_social' => 'ABC Capital, S.A., Institución de Banca Múltiple',
                ],
                [
                    'clave' => '139',
                    'name' => 'UBS BANK',
                    'razon_social' => 'UBS Bank México, S.A., Institución de Banca Múltiple, UBS Grupo Financiero',
                ],
                [
                    'clave' => '140',
                    'name' => 'CONSUBANCO',
                    'razon_social' => 'Consubanco, S.A. Institución de Banca Múltiple',
                ],
                [
                    'clave' => '141',
                    'name' => 'VOLKSWAGEN',
                    'razon_social' => 'Volkswagen Bank, S.A., Institución de Banca Múltiple',
                ],
                [
                    'clave' => '143',
                    'name' => 'CIBANCO',
                    'razon_social' => 'CIBanco, S.A.',
                ],
                [
                    'clave' => '145',
                    'name' => 'BBASE',
                    'razon_social' => 'Banco Base, S.A., Institución de Banca Múltiple',
                ],
                [
                    'clave' => '166',
                    'name' => 'BANSEFI',
                    'razon_social' => 'Banco del Ahorro Nacional y Servicios Financieros, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo',
                ],
                [
                    'clave' => '168',
                    'name' => 'HIPOTECARIA FEDERAL',
                    'razon_social' => 'Sociedad Hipotecaria Federal, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo',
                ],
                [
                    'clave' => '600',
                    'name' => 'MONEXCB',
                    'razon_social' => 'Monex Casa de Bolsa, S.A. de C.V. Monex Grupo Financiero',
                ],
                [
                    'clave' => '601',
                    'name' => 'GBM',
                    'razon_social' => 'GBM Grupo Bursátil Mexicano, S.A. de C.V. Casa de Bolsa',
                ],
                [
                    'clave' => '602',
                    'name' => 'MASARI',
                    'razon_social' => 'Masari Casa de Bolsa, S.A.',
                ],
                [
                    'clave' => '605',
                    'name' => 'VALUE',
                    'razon_social' => 'Value, S.A. de C.V. Casa de Bolsa',
                ],
                [
                    'clave' => '606',
                    'name' => 'ESTRUCTURADORES',
                    'razon_social' => 'Estructuradores del Mercado de Valores Casa de Bolsa, S.A. de C.V.',
                ],
                [
                    'clave' => '607',
                    'name' => 'TIBER',
                    'razon_social' => 'Casa de Cambio Tiber, S.A. de C.V.',
                ],
                [
                    'clave' => '608',
                    'name' => 'VECTOR',
                    'razon_social' => 'Vector Casa de Bolsa, S.A. de C.V.',
                ],
                [
                    'clave' => '610',
                    'name' => 'B&B',
                    'razon_social' => 'B y B, Casa de Cambio, S.A. de C.V.',
                ],
                [
                    'clave' => '614',
                    'name' => 'ACCIVAL',
                    'razon_social' => 'Acciones y Valores Banamex, S.A. de C.V., Casa de Bolsa',
                ],
                [
                    'clave' => '615',
                    'name' => 'MERRILL LYNCH',
                    'razon_social' => 'Merrill Lynch México, S.A. de C.V. Casa de Bolsa',
                ],
                [
                    'clave' => '616',
                    'name' => 'FINAMEX',
                    'razon_social' => 'Casa de Bolsa Finamex, S.A. de C.V.',
                ],
                [
                    'clave' => '617',
                    'name' => 'VALMEX',
                    'razon_social' => 'Valores Mexicanos Casa de Bolsa, S.A. de C.V.',
                ],
                [
                    'clave' => '618',
                    'name' => 'UNICA',
                    'razon_social' => 'Unica Casa de Cambio, S.A. de C.V.',
                ],
                [
                    'clave' => '619',
                    'name' => 'MAPFRE',
                    'razon_social' => 'MAPFRE Tepeyac, S.A.',
                ],
                [
                    'clave' => '620',
                    'name' => 'PROFUTURO',
                    'razon_social' => 'Profuturo G.N.P., S.A. de C.V., Afore',
                ],
                [
                    'clave' => '621',
                    'name' => 'CB ACTINVER',
                    'razon_social' => 'Actinver Casa de Bolsa, S.A. de C.V.',
                ],
                [
                    'clave' => '622',
                    'name' => 'OACTIN',
                    'razon_social' => 'OPERADORA ACTINVER, S.A. DE C.V.',
                ],
                [
                    'clave' => '623',
                    'name' => 'SKANDIA',
                    'razon_social' => 'Skandia Vida, S.A. de C.V.',
                ],
                [
                    'clave' => '626',
                    'name' => 'CBDEUTSCHE',
                    'razon_social' => 'Deutsche Securities, S.A. de C.V. CASA DE BOLSA',
                ],
                [
                    'clave' => '627',
                    'name' => 'ZURICH',
                    'razon_social' => 'Zurich Compañía de Seguros, S.A.',
                ],
                [
                    'clave' => '628',
                    'name' => 'ZURICHVI',
                    'razon_social' => 'Zurich Vida, Compañía de Seguros, S.A.',
                ],
                [
                    'clave' => '629',
                    'name' => 'SU CASITA',
                    'razon_social' => 'Hipotecaria Su Casita, S.A. de C.V. SOFOM ENR',
                ],
                [
                    'clave' => '630',
                    'name' => 'CB INTERCAM',
                    'razon_social' => 'Intercam Casa de Bolsa, S.A. de C.V.',
                ],
                [
                    'clave' => '631',
                    'name' => 'CI BOLSA',
                    'razon_social' => 'CI Casa de Bolsa, S.A. de C.V.',
                ],
                [
                    'clave' => '632',
                    'name' => 'BULLTICK CB',
                    'razon_social' => 'Bulltick Casa de Bolsa, S.A., de C.V.',
                ],
                [
                    'clave' => '633',
                    'name' => 'STERLING',
                    'razon_social' => 'Sterling Casa de Cambio, S.A. de C.V.',
                ],
                [
                    'clave' => '634',
                    'name' => 'FINCOMUN',
                    'razon_social' => 'Fincomún, Servicios Financieros Comunitarios, S.A. de C.V.',
                ],
                [
                    'clave' => '636',
                    'name' => 'HDI SEGUROS',
                    'razon_social' => 'HDI Seguros, S.A. de C.V.',
                ],
                [
                    'clave' => '637',
                    'name' => 'ORDER',
                    'razon_social' => 'Order Express Casa de Cambio, S.A. de C.V',
                ],
                [
                    'clave' => '638',
                    'name' => 'AKALA',
                    'razon_social' => 'Akala, S.A. de C.V., Sociedad Financiera Popular',
                ],
                [
                    'clave' => '640',
                    'name' => 'CB JPMORGAN',
                    'razon_social' => 'J.P. Morgan Casa de Bolsa, S.A. de C.V. J.P. Morgan Grupo Financiero',
                ],
                [
                    'clave' => '642',
                    'name' => 'REFORMA',
                    'razon_social' => 'Operadora de Recursos Reforma, S.A. de C.V., S.F.P.',
                ],
                [
                    'clave' => '646',
                    'name' => 'STP',
                    'razon_social' => 'Sistema de Transferencias y Pagos STP, S.A. de C.V.SOFOM ENR',
                ],
                [
                    'clave' => '647',
                    'name' => 'TELECOMM',
                    'razon_social' => 'Telecomunicaciones de México',
                ],
                [
                    'clave' => '648',
                    'name' => 'EVERCORE',
                    'razon_social' => 'Evercore Casa de Bolsa, S.A. de C.V.',
                ],
                [
                    'clave' => '649',
                    'name' => 'SKANDIA',
                    'razon_social' => 'Skandia Operadora de Fondos, S.A. de C.V.',
                ],
                [
                    'clave' => '651',
                    'name' => 'SEGMTY',
                    'razon_social' => 'Seguros Monterrey New York Life, S.A de C.V',
                ],
                [
                    'clave' => '652',
                    'name' => 'ASEA',
                    'razon_social' => 'Solución Asea, S.A. de C.V., Sociedad Financiera Popular',
                ],
                [
                    'clave' => '653',
                    'name' => 'KUSPIT',
                    'razon_social' => 'Kuspit Casa de Bolsa, S.A. de C.V.',
                ],
                [
                    'clave' => '655',
                    'name' => 'SOFIEXPRESS',
                    'razon_social' => 'J.P. SOFIEXPRESS, S.A. de C.V., S.F.P.',
                ],
                [
                    'clave' => '656',
                    'name' => 'UNAGRA',
                    'razon_social' => 'UNAGRA, S.A. de C.V., S.F.P.',
                ],
                [
                    'clave' => '659',
                    'name' => 'OPCIONES EMPRESARIALES DEL NOROESTE',
                    'razon_social' => 'OPCIONES EMPRESARIALES DEL NORESTE, S.A. DE C.V., S.F.P.',
                ],
                [
                    'clave' => '901',
                    'name' => 'CLS',
                    'razon_social' => 'Cls Bank International',
                ],
                [
                    'clave' => '902',
                    'name' => 'INDEVAL',
                    'razon_social' => 'SD. Indeval, S.A. de C.V.',
                ],
                [
                    'clave' => '670',
                    'name' => 'LIBERTAD',
                    'razon_social' => 'Libertad Servicios Financieros, S.A. De C.V.',
                ],
                [
                    'clave' => '999',
                    'name' => 'N/A',
                    'razon_social' => '',
                ],
        ]);
    }
}
