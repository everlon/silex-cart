<?php
/**
* Author: Everlon Passos (dev@everlon.com.br)
* Date: 20/02/2015 16:53:32
*/
    class Helper {

        public function dataBR($timestamp, $arg=0) {
            //if (!$timestamp) { return false; }

            $date = date('d-m-Y',strtotime($timestamp));
            $time = date('H:i:s',strtotime($timestamp));

            if ($arg == 0) { return $date; } else { return $time; }
        }

        public function dataDB($data) {
            if(strpos($data, '-')){ return implode('-', array_reverse(explode('-', $data))); }
            if(strpos($data, '/')){ return implode('-', array_reverse(explode('/', $data))); }
            return $data;
        }

        public function onlyNumber($string) {
            return preg_replace( '/[^0-9]/', '', $string );
        }
        # Frei Leão (escada branca)
        # São Bernardo de Claraval (São João Maria Vianney)

        public function phone($string) {
            return preg_replace('/([0-9]{2})([0-9]{4})([0-9]{4})/', '($1) $2-$3', $this->onlyNumber($string) );
        }

        public function cria_senha() {
            $pwd = sha1(uniqid(time(), true));
            return substr($pwd, 0, 8);
        }

        public function getDirectorySize($path){ 
            $totalsize = 0; 
            $totalcount = 0; 
            $dircount = 0; 
            if ($handle = opendir ($path)){ 
                while (false !== ($file = readdir($handle))){ 
                    $nextpath = $path . '/' . $file; 
                    if ($file != '.' && $file != '..' && !is_link ($nextpath)){ 
                        if (is_dir ($nextpath)){ 
                            $dircount++; 
                            $result = $this->getDirectorySize($nextpath); 
                            $totalsize += $result['size']; 
                            $totalcount += $result['count']; 
                            $dircount += $result['dircount']; 
                        }elseif (is_file ($nextpath)){ 
                            $totalsize += filesize ($nextpath); 
                            $totalcount++; 
                        } 
                    } 
                } 
            } 
            closedir ($handle); 
            $total['size'] = $totalsize; 
            $total['count'] = $totalcount; 
            $total['dircount'] = $dircount; 
            return $total; 
        } 

        public function sizeFormat($size){ 
            if($size<1024){ 
                return $size." bytes"; 
            }elseif($size<(1024*1024)){ 
                $size=round($size/1024,1); 
                return $size." KB"; 
            }elseif($size<(1024*1024*1024)){ 
                $size=round($size/(1024*1024),1); 
                return $size." MB"; 
            }else{ 
                $size=round($size/(1024*1024*1024),1); 
                return $size." GB"; 
            } 
        } 

        public function formatCpfCnpj($campo, $formatado = true){
            //retira formato
            $codigoLimpo = ereg_replace("[' '-./ t]",'',$campo);
            // pega o tamanho da string menos os digitos verificadores
            $tamanho = (strlen($codigoLimpo) -2);
            //verifica se o tamanho do código informado é válido
            if ($tamanho != 9 && $tamanho != 12){
                return false;
            }   
            if ($formatado){
                // seleciona a máscara para cpf ou cnpj
                $mascara = ($tamanho == 9) ? '###.###.###-##' : '##.###.###/####-##';
                $indice = -1;
                for ($i=0; $i < strlen($mascara); $i++) {
                    if ($mascara[$i]=='#') $mascara[$i] = $codigoLimpo[++$indice];
                }
                //retorna o campo formatado
                $retorno = $mascara;
            }else{
                //se não quer formatado, retorna o campo limpo
                $retorno = $codigoLimpo;
            }   
            return $retorno;
        }   

        public function validaCPF($cpf){
            $cpf = str_pad(ereg_replace('[^0-9]', '', $cpf), 11, '0', STR_PAD_LEFT);
            if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999'){
                return false;
            }else{
                for ($t = 9; $t < 11; $t++) {
                    for ($d = 0, $c = 0; $c < $t; $c++) {
                        $d += $cpf{$c} * (($t + 1) - $c);
                    }
                    $d = ((10 * $d) % 11) % 10;
                    if ($cpf{$c} != $d) {
                        return false;
                    }
                }
                return true;
            }
        }

        public function delTree($dir) { 
            $files = array_diff(scandir($dir), array('.','..')); 
            foreach ($files as $file) { 
                (is_dir("$dir/$file")) ? $this->delTree("$dir/$file") : unlink("$dir/$file"); 
            } 
            return rmdir($dir); 
        } 
    }