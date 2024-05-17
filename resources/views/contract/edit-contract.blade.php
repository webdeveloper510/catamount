<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Document</title>
	</head>
	<body>
 		<!-- Element where PSPDFKit will be mounted. -->
		<div id="pspdfkit" style="height: 100vh"></div>
       
        <script src="{{asset('assets/pspdfkit/pspdfkit.js')}}"></script>
		
        @if(Storage::disk('public')->exists('Contracts/' . $contract->id . '/' . $contract->attachment))
        <script>
			PSPDFKit.load({
				container: "#pspdfkit",
				document: "{{Storage::url('app/public/Contracts/' . $contract->id . '/' . $contract->attachment)}}", // Add the path to your document here.
			})
			.then(function(instance) {
				console.log("PSPDFKit loaded", instance);
			})
			.catch(function(error) {
				console.error(error.message);
			});
		</script>
        
        @endif

		
	</body>
</html>
