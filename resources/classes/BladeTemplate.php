<?php
namespace classes;
/*
# Xử lý view dạng blade template
*/
class BladeTemplate{

	public static function start($path,$var){
		if(is_array($var)){ extract($var); }
		$view = self::repaceToPHP($path);
		$layout = self::layout($view);
		

		if($layout){
		$layout = preg_replace_callback("/@yield\((.+?)\)/", function($layout) use ($view){
			if(preg_match("/@section\({$layout[1]},(.+)\)/", $view, $viewPreg)){
				//Section dạng tham số
				return "<?php echo {$viewPreg[1]}; ?>";
			}else if(preg_match("/@section\({$layout[1]}\)(.*?)@(endsection|stop)/s", $view, $viewPreg)){
				//Section dạng khối
				return $viewPreg[1];
			}else{
				return;
			}
		}, $layout);


		$layout = preg_replace_callback("/@section\((.*?)\)(.*?)@show/s", function($layout) use ($view){
			if(preg_match("/@section\({$layout[1]}\)(.*?)@(endsection|stop)/s", $view, $viewPreg)){
				$out=$viewPreg[1];
				$out=str_replace("@parent", $layout[2], $out);
				return $out;
			}else{
				return $layout[2];
			}
		}, $layout);
		}

		//Xóa section khỏi view
		$viewFilter = [
			"/@extends\((\'|\")(.+?)(\'|\")\)/",
			"/@section\((.+?),(.+)\)/",
			"/@section\((.*?)\)(.*?)@(show|stop|endsection)/s"
		];
		foreach($viewFilter as $from){ $view = preg_replace($from, "", $view); }

		$output = $view."".$layout;
		$output = preg_replace("/(\r|\n|\r\n){2,}/", "\n", $output);
		$output = trim($output);
		if(strpos($output, '<' . '?') !== false) {
   		    eval('?' . '>' . $output);
   	 	}
	}



	//Replace lệnh sang PHP
	private static function repaceToPHP($path){
		if(file_exists($path)){
			$text = file_get_contents($path,FILE_USE_INCLUDE_PATH);
			$replace=[
			"{{--(.+?)--}}"   => "",
			
			"@{{(.+?)}}"      => "@{!!\\1!!}",
		
			"{{(.+?)}}"       => "<?php echo html_encode(\\1); ?>",
		
			"@{!!(.+?)!!}"    => "{{\\1}}",
			
			"{!!(.+?)!!}"     => "<?php echo \\1; ?>",
		
			"@php"            => "<?php",
			"@endphp"         => "?>",
		
			"@if(.+)\)"      => "<?php if\\1): ?>",
			"@elseif(.+)\)"  => "<?php elseif\\1): ?>",
			"@endif"          => "<?php endif; ?>",
		
			"@foreach(.+?)\)" => "<?php foreach\\1): ?>",
			"@endforeach"     => "<?php endforeach; ?>",
			"@continue"       => "<?php continue; ?>",
			"@break"          => "<?php break; ?>",
		
			"@for(.+?)\)"     => "<?php for\\1): ?>",
			"@endfor"         => "<?php endfor; ?>",
		
			"@while(.+?)\)"   => "<?php while\\1): ?>",
			"@endwhile"       => "<?php endwhile; ?>",
		
			"@switch(.+?)\)"  => "<?php switch\\1): ?>",
			"@case\((.+?)\)"  => "<?php case \\1: ?>",
			"@break"          => "<?php break; ?>",
			"@default"        => "<?php default: ?>",
			"@endswitch"      => "<?php endswitch; ?>",
		
			"@json\((.+?)\)"  => "<?php echo json_encode(\\1); ?>",

			];
			foreach($replace as $from=>$to){
				$text = preg_replace("/$from/", "$to", $text);
			}
		}
	return $text ?? FALSE;
	}

	
	//Lấy nội dung layout
	private static function layout($view){
		if( preg_match("/@extends\((\'|\")(.+?)(\'|\")\)/", $view, $getLayout) ){
		$layoutPath=SYSTEM_ROOT."/layouts/{$getLayout[2]}.php";
			if(file_exists($layoutPath)){
				$layout = self::repaceToPHP($layoutPath);
			}
		}
		return $layout ?? FALSE;
	}

}//</Class>