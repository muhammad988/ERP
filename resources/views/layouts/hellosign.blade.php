{{--{{$sign_url}}--}}

    <div id="hs-container"></div>

    <script type="text/javascript" src="js/embedded.development.js"></script>
{{--<script type="text/javascript" src="https://s3.amazonaws.com/cdn.hellofax.com/js/embedded.js"></script>--}}

<script type="text/javascript">
    // import HelloSign from 'hellosign-embedded';

    {{--const client = new HelloSign();--}}

    {{--client.open("{{ $sign_url }}", {--}}
    {{--    clientId: '182bea059aeffb6a3e00329e8376fda0'--}}
    {{--});--}}
    {{--HelloSign.init("182bea059aeffb6a3e00329e8376fda0");--}}
    {{--HelloSign.open({--}}
    {{--    // Set the sign_url passed from the controller.--}}
    {{--    url: "{{ $sign_url }}",--}}
    {{--    allowCancel: false,--}}
    {{--    --}}{{--redirectUrl: '{{ route('sign-agreement') }}',--}}
    {{--    skipDomainVerification: true,--}}
    {{--    height: 800,--}}
    {{--    // Set the debug mode based on the test mode toggle.--}}
    {{--    debug: true,--}}
    {{--    // Point at the div we added in the content section.--}}
    {{--    container: document.getElementById("hs-container"),--}}
    {{--    // Define a callback for processing events.--}}
    {{--    messageListener: function(e) {--}}
    {{--        if (e.event == 'signature_request_signed') {--}}
    {{--            alert('test');--}}
    {{--            // Process what to do once they are finished signing.--}}
    {{--        }--}}
    {{--    }--}}
    {{--});--}}
    {{--HelloSign.on('sign', (data) => {--}}
    {{--    console.log('The document has been signed!');--}}
    {{--    console.log('Signature ID: ' + data.signatureId);--}}
    {{--});--}}
</script>
    <script type="text/javascript">
        const client = new HelloSign({
            clientId: "182bea059aeffb6a3e00329e8376fda0"
        });

        client.open("{{ $sign_url }}", {
            debug: true,
            allowCancel: false,
            skipDomainVerification: true,
            height: 800,
            container: document.getElementById("hs-container"),
        });
    </script>
