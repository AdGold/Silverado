<?php
function checkcode($code)
{
    if (preg_match('/\d{5}-\d{5}-[A-Z]{2}/', $code))
    {
        $chk1 = (((($code[0] + $code[1]) * $code[2]) + $code[3]) * $code[4]) % 26;
        $chk2 = (((($code[6] + $code[7]) * $code[8]) + $code[9]) * $code[10]) % 26;
        if ($chk1 + ord('A') == ord($code[12]) && $chk2 + ord('A') == ord($code[13]) )
            return 1;
        else
            return 0;
    }
    else
        return 0;
}
?>
