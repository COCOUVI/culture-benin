@props(['url'])
<tr>
    <td class="header" style="text-align: center; padding: 30px 20px;">
        <a href="{{ $url }}" style="display: inline-block; text-decoration: none;">
            @if (trim($slot) === 'Laravel')
                <img
                    src="https://res.cloudinary.com/dvne7dd7h/image/upload/v1764621782/carte-contour-du-pays-du-benin-illustration-vectorielle_628809-607-removebg-preview_oeed84.png"
                    class="logo"
                    alt="Culture Bénin"
                    style="
                        width: 240px;
                        max-width: 100%;
                        height: auto;
                        display: block;
                        margin: 0 auto;
                        border: 0;
                        outline: none;
                        -ms-interpolation-mode: bicubic;
                    "
                >
            @else
                {!! $slot !!}
            @endif
        </a>
    </td>
</tr>
