@extends('crudbooster::admin_template')
@section('content')
<?php
$userid = CRUDBooster::myId();
if ($userid === null) {
    ?>
    <script>
        window.location.replace("../../admin/login");
    </script>
<?php
}
?>


<style>
    /* Fixed sidenav, full height */
    .sidenav {
        height: 100%;
        width: 100%;
        position: absolute;
        z-index: 1;
        top: 0;
        left: 0;
        background-color: #fff;
        overflow-x: hidden;
    }

    /* Style the sidenav links and the dropdown button */
    .sidenav a,
    .dropdown-btn {
        padding: 6px 8px 6px 16px;
        text-decoration: none;
        font-size: 18px;
        color: #818181;
        display: block;
        border: none;
        background: #fff;
        width: 100%;
        text-align: left;
        cursor: pointer;
        outline: none;
    }

    /* On mouse-over */
    .sidenav a:hover,
    .dropdown-btn:hover {
        color: #afadad;
    }

    /* Main content */
    .main {
        margin-left: 200px;
        /* Same as the width of the sidenav */
        font-size: 20px;
        /* Increased text to enable scrolling */
        padding: 0px 10px;
    }

    /* Add an active class to the active dropdown button */
    .active {
        background-color: #ecf0f5;
        color: #000;
    }

    /* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
    .dropdown-container {
        display: none;
        background-color: #fff;
        padding-left: 8px;
    }

    /* Optional: Style the caret down icon */
    .fa-caret-down {
        float: right;
        padding-right: 8px;
    }

    /* Some media queries for responsiveness */
    @media screen and (max-height: 450px) {
        .sidenav {
            padding-top: 5px;
        }

        .sidenav a {
            font-size: 18px;
        }
    }
</style>
<!-- estilos de popup -->


<style>
    html,
    body {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
    }

    body {
        color: #666;
        background-color: #ccc;
        font-family: "Lucida Grande", "Lucida Sans Unicode", "DejaVu Sans", Lucida, Arial, Helvetica, sans-serif;
    }

    a {
        color: #0095dd;
        text-decoration: none;
    }

    a:hover,
    a:focus {
        color: #2255aa;
        text-decoration: underline;
    }

    figure {
        max-width: 1024px;
        max-width: 64rem;
        width: 100%;
        height: 100%;
        max-height: 494px;
        max-height: 30.875rem;
        margin: 20px auto;
        margin: 1.25rem auto;
        padding: 20px;
        padding: 1.051%;
        background-color: #666;
    }

    figcaption {
        display: block;
        font-size: 12px;
        font-size: 0.75rem;
        color: #fff;
    }

    video {
        width: 30%;
        margin: 15px;
    }

    /* controls */
    .controls,
    .controls>* {
        padding: 0;
        margin: 0;
    }

    .controls {
        overflow: hidden;
        background: transparent;
        width: 100%;
        height: 8.0971659919028340080971659919028%;
        /* of figure's height */
        position: relative;
    }

    .controls[data-state=hidden] {
        display: none;
    }

    .controls[data-state=visible] {
        display: block;
    }

    .controls>* {
        float: left;
        width: 3.90625%;
        height: 100%;
        margin-left: 0.1953125%;
        display: block;
    }

    .controls>*:first-child {
        margin-left: 0;
    }

    .controls .progress {
        cursor: pointer;
        width: 75.390625%;
    }

    .controls button {
        text-align: center;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        border: none;
        cursor: pointer;
        text-indent: -99999px;
        background: transparent;
        background-size: contain;
        background-repeat: no-repeat;
    }

    .controls button:hover,
    .controls button:focus {
        opacity: 0.5;
    }

    .controls button[data-state="play"] {
        background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2ZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDpFNDZDNDg2MEEzMjFFMjExOTBEQkQ4OEMzRUMyQjhERCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpCNkU0NTY5NkE0MDcxMUUyQjgwQkYzQzhCMDZBRTU1NCIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpCNkU0NTY5NUE0MDcxMUUyQjgwQkYzQzhCMDZBRTU1NCIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M2IChXaW5kb3dzKSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjQzQ0QwNDBBMDJBNEUyMTFCOTZEQzYyRDgyRUVBOUZDIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkU0NkM0ODYwQTMyMUUyMTE5MERCRDg4QzNFQzJCOEREIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+kBUJ9AAAAXFJREFUeNrsmLtOAkEUhneQyiAdDTExGlYMBaW9oq/ge8jlUbwkthTY2EGBLehbKK0UxsQgVK7/SWbMZo3j3mbmxPAnXyi2+fIzZ3dmRBAEHucUPO6hBhUyNXAH3umxJRZgCBo/nCKCe+DVoliUN5LUCd46lFOMwk4iPCRCiDl+Ko5X3RJOm99OEcGAyVyIrFO8lEPE9jXTBNvgRq4ba6+ZuAs5nFMwy3NQdFOcRpBSBtfgk6ugykkebZoUpGyBqyxtmhZUaYFnzoKqzcukbdoUVDkGT5wFKSVwEadNV4IqR3+16VrQkxuSVRxBVzvqKija+tQl/fafyx00u7/YBxOOU0yttcEHx9fMPphy/JJQa50krdkUrIMHjruZDdBN25ppwYOsrZkSpNZ68hDFast/Bg7Bo4nDu+7g/m/Oxc6u3+YMnBY6wTEDwXvdbmYXvDi82aKrP183xZQd0LcsSktrIC9PvV+neH1HvRZ0kC8BBgADq2RhyZa7BQAAAABJRU5ErkJggg==');
    }

    .controls button[data-state="pause"] {
        background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2ZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDpFNDZDNDg2MEEzMjFFMjExOTBEQkQ4OEMzRUMyQjhERCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpCNzE0QzJGQUE0MDcxMUUyQjgwQkYzQzhCMDZBRTU1NCIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpCNzAxODM5QUE0MDcxMUUyQjgwQkYzQzhCMDZBRTU1NCIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M2IChXaW5kb3dzKSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjQzQ0QwNDBBMDJBNEUyMTFCOTZEQzYyRDgyRUVBOUZDIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkU0NkM0ODYwQTMyMUUyMTE5MERCRDg4QzNFQzJCOEREIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+r7sqzQAAANdJREFUeNrs2MEKwjAMBuDGswd9C/UdPHvy6Ft6UTyKr6RDcceawDpKHZsE2kb4Az87GOiHNLCFvPfOcs2c9ZJ/MKSrDefCaeXnQmm7M9dfpgQoDY+CsDRy9moMeKqICznGJoqHhIie/JhXvnUNmxa9KQF6I3NBfzPFANYC7uTKRtkqeyZLOyQ0dLcVPRgSAAEEEEAAAQQQwJ9ftzQ92YAHzjLKXtmT7YUVX3UA5gK+DJiaMeDNAPCaToyl9dvdTazfpMIC810QJmed3cACk7CjBrByfQQYAHwMIXlfZRgfAAAAAElFTkSuQmCC');
    }

    .controls button[data-state="stop"] {
        background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2ZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDpFNDZDNDg2MEEzMjFFMjExOTBEQkQ4OEMzRUMyQjhERCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpCNzAxODM5M0E0MDcxMUUyQjgwQkYzQzhCMDZBRTU1NCIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpCNzAxODM5MkE0MDcxMUUyQjgwQkYzQzhCMDZBRTU1NCIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M2IChXaW5kb3dzKSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjQzQ0QwNDBBMDJBNEUyMTFCOTZEQzYyRDgyRUVBOUZDIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkU0NkM0ODYwQTMyMUUyMTE5MERCRDg4QzNFQzJCOEREIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+KkF/7gAAAOFJREFUeNrsmMsKwjAQRTNdu/ELpAUR/AVdC/6nu66kK/0hFXyBj22cQCohQqDUJFO4A4cusphDmFvaIa21klyFkl7mBltszZgt8zTHiXgzDTP/cfIEp8wtoZjP3UiGBOuMci2N60RuSIjoyo9x5ql7sdPo6+QJaiG5oMGkGIKpBddmVHuy7NKwa0gK+yronYNYIdGYQQhCEIIQhCAEIThoQZIuuPpDz0XMD1b81SHFsQUvApweIcGdAMG9nxh3u1UyJ5Vvs3VmqtD6zdSE2TCHhGJH27P0L42wo4Zg5voIMAB0bCBXvSa7VQAAAABJRU5ErkJggg==');
    }

    .controls button[data-state="mute"] {
        background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2ZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDpFNDZDNDg2MEEzMjFFMjExOTBEQkQ4OEMzRUMyQjhERCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpBMzYxQThBMUE0MDcxMUUyQjgwQkYzQzhCMDZBRTU1NCIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpBMzYxQThBMEE0MDcxMUUyQjgwQkYzQzhCMDZBRTU1NCIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M2IChXaW5kb3dzKSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjQzQ0QwNDBBMDJBNEUyMTFCOTZEQzYyRDgyRUVBOUZDIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkU0NkM0ODYwQTMyMUUyMTE5MERCRDg4QzNFQzJCOEREIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+ohJkMQAAAjNJREFUeNrsmM8rRFEUx8ePxo8YokmJpMiGkIWU8mNJIZRkKcWGnfwDNgoh2ZB/gWzsKXakiSaUskP5LaMxz/fWmTqd3rx5Y96dod6pT3r33td83HPfvee9DMMwPH85MlxBV9AVjBNKkJNEzInrcpCbtI9DguMgIn8LfINrsA16QXY6BPtAmISkoETJjqmllSrBbvDJBHjcgFAM0X3g1y3YDJ7ED8tQKW0DC+BBjL0E1boEa8Cdyczw6AJV7LoYrNBa5ZKlTgtW0Foy4ghG287BLMij9hHwwfp3nRQsAmcx5OI9JFegkfr6xUwOOyGYD44s5OTNB+BZ9Ks120D9K2KWM+0KroGvOCJ2BFV4wQR4YWMuQA5l45G1d9oVDP9Szmr6VWpf2bhpal9mbet2BQ0Ngipm2LhTautkbSfpFixgm3qEUuxj976bCWamsC55o/XnoaOunNbmG3sI8+RNqRR0rNzSleJCkWLfX0vxOG0vHtrsVXpbWH/Q7CYzwYgGuSYwz6436e8Aazuym+KNJPZCGWrGJsUeGN2oi8VG3eHEUXecgOChOEEMEqqn/lXWHkjkqLMKfxLFgpq5OpZaXiwMOl1u3SYgGKBTxMsqGV5u7egoWGttFKzqGKsUJ8mSScFaoqvkb7VR8quHoR0sgnsxNij+AW0vTaEYgncWa3VPlvo6XzuHEnjtVCkdTceL+1QMwTBJbYEekJWuLwtmnz7K2NH269rA/brlCrqC/13wR4ABACa7olAORNxuAAAAAElFTkSuQmCC');
    }

    .controls button[data-state="unmute"] {
        background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2ZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDpFNDZDNDg2MEEzMjFFMjExOTBEQkQ4OEMzRUMyQjhERCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpBMzk2MTA2OUE0MDcxMUUyQjgwQkYzQzhCMDZBRTU1NCIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpBMzk2MTA2OEE0MDcxMUUyQjgwQkYzQzhCMDZBRTU1NCIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M2IChXaW5kb3dzKSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjQzQ0QwNDBBMDJBNEUyMTFCOTZEQzYyRDgyRUVBOUZDIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkU0NkM0ODYwQTMyMUUyMTE5MERCRDg4QzNFQzJCOEREIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+LD0czAAAARZJREFUeNrsly8LAkEQxW/lksUgGMxWs8VgEdRgEMwmv4Lfw2TwawgaxGI2WQ0Gm0WDBv+db3SFK4K3nnMjzIMfF/exzHs7Z4Ig8CQr5QmXGlSDf2fQGONKz8kh1UwUHNUBt6hnPc5jMNgEl+ddyDNYAQcy52rQRD2U5ulDFcEcZELjZKSkuACmYXOSaiYPxiAnsQfpxib2BsUVdRqM7Owl+pL0wemVzBCU1nLc8+KS4jM+vuOjwJJi32OUbjNqUA3+wOBVusGB3e9YFOe6RU/dDJSSLup3OoIaWEoOyQ40wFpyijegCraSa2YF6mAvuQcXoGVXM7FFTaluf9WdTD/uXdcfd67dbgiyLEWty4IaVIPCdBdgAJkkaR2v57S0AAAAAElFTkSuQmCC');
    }

    .controls button[data-state="volup"] {
        background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2ZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDpFNDZDNDg2MEEzMjFFMjExOTBEQkQ4OEMzRUMyQjhERCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpCNzU1OEJFREE0MDcxMUUyQjgwQkYzQzhCMDZBRTU1NCIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpCNzU1OEJFQ0E0MDcxMUUyQjgwQkYzQzhCMDZBRTU1NCIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M2IChXaW5kb3dzKSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjQzQ0QwNDBBMDJBNEUyMTFCOTZEQzYyRDgyRUVBOUZDIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkU0NkM0ODYwQTMyMUUyMTE5MERCRDg4QzNFQzJCOEREIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+1Pk2GwAAAQ9JREFUeNrsmL0KwjAQgHMOiogIPoLSQR9CcdDRxclXLIrg2mdSsYK41HjBVEJsM6XNld7BR6GF9mu4y8+BlFJQjo6gHmoEc3REyAG5qcc1cUViZPrnZAnOahazuSATl+A5oFxObDqBWSQA8MRLP3DWpeg0+jlZgpJIXUBjqrg1gmuVIRY7Hy/2lYNQ8vMZ5Rx8cw6yYNsENwVTCZRUsFndOQNkrNlXMc2A54HJKC91Peo52PUt+KBeJENk4fG7SwprsdA7ZN4PsiALVrny+BJcFdzbUtry87GzMYIvAk6pSzAhIJjYCWl2t+YibPtN9QkjV/tNheoRnvRQ1yV2R47i2zwVpe03rmIWDBAfAQYAByYx7rBsQ/AAAAAASUVORK5CYII=');
    }

    .controls button[data-state="voldown"] {
        background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2ZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDpFNDZDNDg2MEEzMjFFMjExOTBEQkQ4OEMzRUMyQjhERCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpCNzU1OEJGMUE0MDcxMUUyQjgwQkYzQzhCMDZBRTU1NCIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpCNzU1OEJGMEE0MDcxMUUyQjgwQkYzQzhCMDZBRTU1NCIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M2IChXaW5kb3dzKSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjQzQ0QwNDBBMDJBNEUyMTFCOTZEQzYyRDgyRUVBOUZDIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkU0NkM0ODYwQTMyMUUyMTE5MERCRDg4QzNFQzJCOEREIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+B37OGAAAANpJREFUeNrs2MEKwjAMBuDGk0efwSGCr6FXfU/FHeZV30hQ50U8dSmsMiLUCV0b5Q/87DDYPspCRshaazTXyGgvd4I+bc05e87V3U6UC2fLKd5MArhIDJM5c6Yh4CEjzmfXNVG3SYjowZdx5q+uZtPkZRJAq6Qv6Ge6GEAAAQQQwP61csMmUpZ9X/rNqKPYEw2j7p+BNARwHek7dM/YDNEk+B9EkwAIIIAAfgY+FZjuIeBJAfAo555cv91Mvs2W2xMWofWbR1btUaeC1ZySM5OHRthRA5i5GgEGAJmoHqaNWADvAAAAAElFTkSuQmCC');
    }

    .controls button[data-state="go-fullscreen"] {
        background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2ZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDpFNDZDNDg2MEEzMjFFMjExOTBEQkQ4OEMzRUMyQjhERCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpCM0M2OUNCREE0MDcxMUUyQjgwQkYzQzhCMDZBRTU1NCIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpCM0M2OUNCQ0E0MDcxMUUyQjgwQkYzQzhCMDZBRTU1NCIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M2IChXaW5kb3dzKSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjQzQ0QwNDBBMDJBNEUyMTFCOTZEQzYyRDgyRUVBOUZDIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkU0NkM0ODYwQTMyMUUyMTE5MERCRDg4QzNFQzJCOEREIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+cU+iTAAAAZBJREFUeNrs2D9OwzAUBvC6iMMgBgYGpLIxIqYS0cPQKkOIuBErZ2DiDnQoHVBpaQnPEpUs13+e/T5LHfKkb6mr+BfHbh2rrusGx1yqB0pLA83ojyKpBd09xa5/4EkE1oAxaUoBa+CDa7jAIfOCv5R3IPCVskXPQX3BBwDuhvKFesRrMNKF2+UC9Zy7onw6kBMQTg/ArTknuUBzQSCQXpzRb8MFularBBkaObvvhgP0VQ4yiHMtUgkwFRnFlQCGkFUqrhTQhZxTLoz2e8omhisJNJE2zkZ6cRzgwXZLKZWK/Ka8edo1ckV5CQGT9oOJQMh2L1TDwZGXFDimXAbazykj9I6aW9X/Ilh4kBr3QVlSrnMXSS6wsn5GbOQet2/3IksAbZwLMGZ8pwhQ4344HTNvBAr04UaS0c4BtiAcC2n1/cjdsLYgXBRp9DtN3fK3IBxnJKe5L007EC6EXKFe3JfifwU/UgzcgHAmcos8WTil3AGBZ5STEqdbzwDcrOTplhQ5Sz1+609Ye2APjNSfAAMAv4p3Pa/O/tsAAAAASUVORK5CYII=');
    }

    .controls button[data-state="cancel-fullscreen"] {
        background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2ZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDpFNDZDNDg2MEEzMjFFMjExOTBEQkQ4OEMzRUMyQjhERCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpCM0M2OUNCOUE0MDcxMUUyQjgwQkYzQzhCMDZBRTU1NCIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpCMzlFNDkzMUE0MDcxMUUyQjgwQkYzQzhCMDZBRTU1NCIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M2IChXaW5kb3dzKSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjQzQ0QwNDBBMDJBNEUyMTFCOTZEQzYyRDgyRUVBOUZDIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkU0NkM0ODYwQTMyMUUyMTE5MERCRDg4QzNFQzJCOEREIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+1VELOwAAAadJREFUeNrs2EtOwzAQBuAEOAEIKsQluAAbGqSGHRIrEKveoQEWNOF0SFyGZ6GkwowlWwpm7IwdT8kiI/2LWk39yY4faiqESPpcG0nPq/fARE5xM0btrIGw7fQ4gJeQJ8gRI24MeYac+wIvICv5fcgrE1Li3lUftUZSgAeQhXpQMCGbOJ03yC51BM8gSyYkhpN95b7voA+yQtpukLbMgjsNWSRUZKXa/2wQBjJzjVwosA1ZNdowoMwtFRcKtCHNzzagsDybk/ZlItCGpAJJuK5AjVx1ANYuHAb0PYsPIZsdtpgt9RvRzuIEWa1dp1hYtqBOU3zf0qEvUK/uVmBqotI0/ffb1XBhHYBIlQyL5Dr2NlNGBBZcJ0kZAVhwniQP6qgLrS/II9dJMoF8RhhBee06jj3FGK72ANYIchwLiOFkByeQOQFYqCv9koL0BeYOnK65AzgzfgtDZqFACk7XHdI2Q9pakVTgxAPnW7lruinAfcgHE86FfIHsUUdwCvlmwmFIubde+b6DU/V3BAeuiVxoXMgqHq3hwjLyulEP98EBOAB/148AAwA7RI/R8UopbwAAAABJRU5ErkJggg==');
    }

    .controls progress {
        display: block;
        width: 100%;
        height: 81%;
        margin-top: 2px;
        margin-top: 0.125rem;
        border: none;
        overflow: hidden;
        -moz-border-radius: 2px;
        -webkit-border-radius: 2px;
        border-radius: 2px;
        color: #0095dd;
        /* Internet Explorer uses this value as the progress bar's value colour */
    }

    .controls progress[data-state="fake"] {
        background: #e6e6e6;
        height: 65%;
    }

    .controls progress span {
        width: 0%;
        height: 100%;
        display: inline-block;
        background-color: #2a84cd;
    }

    .controls progress::-moz-progress-bar {
        background-color: #0095dd;
    }

    /* Chrome requires its own rule for this, otherwise it ignores it */
    .controls progress::-webkit-progress-value {
        background-color: #0095dd;
    }

    /* fullscreen */
    html:-ms-fullscreen {
        width: 100%;
    }

    :-webkit-full-screen {
        background-color: transparent;
    }

    video:-webkit-full-screen+.controls {
        background: #ccc;
        /* required for Chrome which doesn't heed the transparent value set above */
    }

    video:-webkit-full-screen+.controls progress {
        margin-top: 0.5rem;
    }

    /* hide controls on fullscreen with WebKit */
    figure[data-fullscreen=true] video::-webkit-media-controls {
        display: none !important;
    }

    figure[data-fullscreen=true] {
        max-width: 100%;
        width: 100%;
        margin: 0;
        padding: 0;
        max-height: 100%;
    }

    figure[data-fullscreen=true] video {
        height: auto;
    }

    figure[data-fullscreen=true] figcaption {
        display: none;
    }

    figure[data-fullscreen=true] .controls {
        position: absolute;
        bottom: 2%;
        width: 100%;
        z-index: 2147483647;
    }

    figure[data-fullscreen=true] .controls li {
        width: 5%;
    }

    figure[data-fullscreen=true] .controls .progress {
        width: 68%;
    }

    /* Media Queries */
    @media screen and (max-width:2000px) {
        figure {
            padding-left: 0;
            padding-right: 0;
            height: auto;
        }

        .controls {
            /* we want the buttons to be proportionally bigger, so give their parent a set height */
            height: 30px;
            height: 1.876rem;
        }
    }

    @media screen and (max-width:42.5em) {
        .controls {
            height: auto;
        }

        .controls>* {
            display: block;
            width: 16.6667%;
            margin-left: 0;
            height: 40px;
            height: 2.5rem;
            margin-top: 2.5rem;
        }

        .controls .progress {
            /*display:table-caption;*/
            /* this trick doesn't work as elements are floated and the layout doesn't work */
            position: absolute;
            top: 0;
            width: 100%;
            float: none;
            margin-top: 0;
        }

        .controls .progress progress {
            width: 98%;
            margin: 0 auto;
        }

        .controls button {
            background-position: center center;
        }

        figcaption {
            text-align: center;
            margin-top: 0.5rem;
        }
    }
</style>

<style>
    .btn-video {
        height: 40px;
        background: #ffffff;
        width: 40px;
        background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAclBMVEX///8AAADV1dXJycnQ0NB6enoZGRkTExONjY3g4OBWVlbb29v29vb7+/vq6uoEBARycnKGhoZQUFDDw8OZmZlBQUFtbW3s7Ozy8vKpqamAgICSkpIvLy8lJSUdHR2srKxfX1+6urpJSUk4ODgiIiJUVFR5CACAAAADiUlEQVR4nO3da1PiMBiG4aKcKSdRQUAEdP//X1x2w5k2pybzPqnP9X1ncs+OtX3jJFkW0Wi67jTM1quYi4ipZ1Gn9KWX6qllXdgYSa/Vz8S+sCm9Vj9dFrIQHgtZiI+FLMTHQhbiYyEL8bGQhfhYyEJ8LGQhPhayEB8LWYiPhSzEx0IW4mMhC/GxkIX4WMhCfCxkIT4WshAfC1mIj4UsxMdCFuJjIQvxsZCF+FjIQnwsZCE+Fl55kl6rn5V94b5frPUlHXGQ90qMHE7+KPcp3ZdtQ2ToDIQDZ7EDG7lw4Tx24FQ4MMuWcQM30n0Hm6iFCIcPjWIGPkvX/RcxsSvddvQcK3AvXXb2EalwIR12EeTt5QHGD+HRPkIg1kl8Q5vTA928SDfdCf9AlX5bexD6BRXwm/g1aOCrdE6R94CBW+mYYt/BAttD6ZZi+ThUofRXb6lBoMAP6ZByYR6oW+kMHYfxWqm2dIRegMFUT7rBoPIDFWFCqrWoGDiRDjB7qhQoPwC2sKtSiDB5Mpv6B86k126p7xsoP/619ekX+Ca9bnues36gyZNR0ycQavJk5DFgxJo8mTnv2PyRXrGzF7fAMehHr47bgBH2o1fDacAI/75dyGHH5l16rZ6sH6hr6ZV6s72HJY337UJvVoE76WVWkNs8UJfSq6zE4s6nhN63C5kHjHCbTK5MOzaJ/lniNf2ODfB8295aE5jqr/pbeXlgur/qb5Xv2MyllxbKriQwra96reI/+U7tq16raMcm1XsdSzw+UDcJftXrPA4Y0XfRnN3v2KQywHfwVd+nzMn1js1WejFxXAaMdXmXuTf8OQZ2kv9iKnN6oCY8lzHJ/31K7WsceLBo1ruPIhlMWhrYs76lbumT03aPfn9hLFpgol36+ftTX4j9h3T6iTMLWYiAhQoLkbFQYSEyFiosRMZChYXIWKiwEBkLFRYiY6HCQmQsVFiIjIUKC5GxUGEhMhYqLETGQoWFyFiosBAZCxUWImOhwkJkIQo7gydcgxCFKWNh+liYPhamj4XpY2H6WJg+Fqbv9xRWOyce2eksOM1ZXIk7n/HjecA4vMv5IpFv2hRzOcS+rj+IV6cv2x2kmprrCyLr+Z94c4B2nCsaZd1dJaE7nzJN37eBWf5j/jdJWT+cdzes19Om8AbMsBcYyio52XZel+fNtPyyk+Gs2+8Eu+NPwLi9Xd0divoXobRX9zE7olEAAAAASUVORK5CYII=");
        position: absolute;
        left: 50%;
        top: 25px;
        z-index: 1;
    }
</style>

<div class="box">
    <div class="box-header">
        <span style="font-size: 20px;"> Grabaciones </span>
        <a href="http://xtamvideo.test/admin/maps" class="btn btn-sm btn-primary" title="Ver mapa">Ver mapa</a>
        <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#myModal" title="Busqueda avanzada">Búsqueda avanzada</button>
    </div>
    <div class="box-body">
        <div class="col-md-3">
            <div class="content">
                <div class="sidenav" id="nav" style="min-height: 50vh;">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Camaras</h3>
                        </div>
                        <div class="panel-body">
                            <?php
                            foreach ($typecam as $type) {
                                echo "<button class='dropdown-btn'>" . $type->desc_cam . "<i class='fa fa-caret-down'></i> </button>";
                                echo "<div class='dropdown-container' data-name='principal'>";
                                $temp = '';
                                foreach ($camaras as $camara) {
                                    if ($type->desc_cam == $camara->desc_cam) {
                                        if ($temp <> $camara->descripcion) {
                                            if ($temp <> '') {
                                                echo "</div>";
                                            }
                                            $temp = $camara->descripcion;
                                            echo "<button class='dropdown-btn'>" . $camara->descripcion . "<i class='fa fa-caret-down'></i> </button>";
                                            echo "<div class='dropdown-container'>";
                                        }
                                        echo "<a id='" . ($camara->descripcion . "" . $camara->dcamara) . "' href='http://localhost/xtamvideo/resources/views/grabaciones/video.mp4' draggable='true' ondragstart='drag(event)'>" . $camara->dcamara . "</a>";
                                    }
                                }
                                if ($temp <> '') {
                                    echo "</div>";
                                }
                                echo "</div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Visualizacion de camaras</h3>
                        </div>
                        <div class="VideoCont" id="videoCont" ondrop="drop(event)" ondragover="allowDrop(event)" style="min-height: 50vh; ">

                        </div>
                        <div class=" panel-footer" id="Controls" style="min-height: 5vh; display: none;">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="input-group date">
                                        <label class="control-label">Fecha inicial</label>
                                        <input id="dateinitial" type="date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group date">
                                        <label class="control-label">Hora inicial</label>
                                        <input type="time" id="timeinitial" class="form-control" name="timeinitial" required>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="input-group date">
                                        <label class="control-label">Fecha final</label>
                                        <input id="dateinitial" type="date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group date">
                                        <label class="control-label">Hora final</label>
                                        <input type="time" id="timeend" class="form-control" name="timeend" required>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="video-controls" class="controls" data-state="hidden">
                                        <button id="playpause" type="button" class="btn btn-lg btn-default" data-state="play">Play/Pause</button>
                                        <button id="stop" type="button" class="btn btn-lg btn-default" data-state="stop">Stop</button>
                                        <div class="progress">
                                            <progress id="progress" value="0" min="0">
                                                <span id="progress-bar"></span>
                                            </progress>
                                        </div>
                                        <button id="mute" type="button" class="btn btn-lg btn-default" data-state="mute">Mute/Unmute</button>
                                        <button id="volinc" type="button" class="btn btn-lg btn-default" data-state="volup">Vol+</button>
                                        <button id="voldec" type="button" class="btn btn-lg btn-default" data-state="voldown">Vol-</button>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row text-right">
                                <div class="col-md-5 col-md-offset-7">
                                    <button class="btn btn-sm btn-warning">Ver</button>
                                    <button class="btn btn-sm btn-default" data-toggle="modal" data-target="#export">Exportar</button>
                                    <button class="btn btn-sm btn-success">Actualizar</button>
                                    <button class="btn btn-sm btn-danger" onclick="eliminarElemento()">Borrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- popup search advanced -->
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Filtro de búsqueda avanzada</h4>
            </div>

            <div class="modal-body">
                <div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <input type="text" class="form-control" name="x" placeholder="Palabra clave">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="input-group" style="padding-top: 20px; padding-bottom: 20px;">
                                <label class="radio-inline control-label">
                                    <input type="radio" checked name="optradio">Todas las palabras
                                </label>
                                <label class="radio-inline control-label">
                                    <input type="radio" name="optradio">Cualquier palabra
                                </label>
                                <label class="radio-inline control-label">
                                    <input type="radio" name="optradio">Frase exacta
                                </label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">

                                <label type="text"> Nombre cámara </label>
                                <input type="text" class="form-control" name="x" placeholder="">

                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">

                                <label type="text"> Tipo de cámara: </label>
                                <select class="form-control" type="text">
                                </select>

                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">

                                <label type="text"> Tipo de cámara: </label>
                                <select class="form-control" type="text">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class=" btn btn-sm btn-primary" data-dismiss="modal">Cerrar</button>
                <button type="button" class=" btn btn-sm btn-danger" onclick="limpiaCampo()" data-dismiss="modal">Borrar</button>
                <button type="button" class=" btn btn-sm btn-success" onclick="redirect()" data-dismiss="modal">Consultar</button>
            </div>
        </div>
    </div>
</div>

<!-- popup video export  -->
<!-- Modal -->
<div class="modal fade" id="export" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Exportar video</h4>
            </div>

            <div class="modal-body">
                <div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="checkbox" onchange="checkformat(this.checked);" id="check">
                                <label class="form-group"> Cambiar formato de video</label>
                                <select id="id_select" class="form-control" type="text" disabled>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="checkbox" onchange="checkname(this.checked);">
                                <label class="form-group"> Cambiar nombre</label>
                                <input id="chkname" type="text" class="form-control" disabled>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12">
                            <div class="input-group">
                                <input type="checkbox">
                                <label class="form-group"> Agregar fecha y hora</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class=" btn btn-sm btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="button" class=" btn btn-sm btn-success" data-dismiss="modal">Generar</button>
            </div>
        </div>
    </div>
</div>

<!-- Busqueda avanzada -->
<script>
    function redirect() {
        window.location.replace("../../public/admin/searchadvanced");
    }
</script>

<script>
    // sidevar collapsed
    document.body.className = "skin-red sidebar-collapse";
    // sidevar collapsed
</script>
<!-- Function check export video -  change name -->
<script>
    function checkformat(value) {
        if (value == true) {
            // habilitamos
            document.getElementById("id_select").disabled = false;
        } else if (value == false) {
            // deshabilitamos
            document.getElementById("id_select").disabled = true;
        }
    }

    function checkname(value) {
        if (value == true) {
            // habilitamos
            document.getElementById("chkname").disabled = false;
        } else if (value == false) {
            // deshabilitamos
            document.getElementById("chkname").disabled = true;
        }
    }
</script>



<!-- Drag and drop -->
<script>
    function allowDrop(ev) {
        ev.preventDefault();
    }

    function drag(ev) {
        ev.dataTransfer.setData("Data", ev.target.id);
    }

    var supportsProgress = (document.createElement('progress').max !== undefined);
    if (!supportsProgress) {
        progress.setAttribute('data-state', 'fake');
    }

    /*progress.addEventListener('click', function(e) {
        var pos = (e.pageX - (this.offsetLeft + this.offsetParent.offsetLeft)) / this.offsetWidth;
        x.currentTime = pos * video.duration;
    });*/

    function drop(ev) {
        ev.preventDefault();
        var data = ev.dataTransfer.getData("Data");
        var son = document.getElementById(data);
        var route = son.getAttribute("data-route");
        var x = document.createElement("VIDEO");
        x.setAttribute("data-type", "video");
        x.setAttribute("id", "cam_" + son.id);
        x.addEventListener('click', function() {
            var video = document.createElement("a");
            video.setAttribute("href", "http://localhost/xtamvideo/resources/views/grabaciones/videoplayback.mp4");
            video.setAttribute("download", son.id + ".mp4");
            video.click();
        }, false);

        x.addEventListener('play', function() {
            changeButtonState('playpause');
        }, false);

        x.addEventListener('pause', function() {
            changeButtonState('playpause');
        }, false);

        if (!route) {
            x.setAttribute("src", "http://localhost/xtamvideo/resources/views/grabaciones/videoplayback.mp4");
            document.getElementById("Controls").style.display = "";

            var duration = "";
            x.addEventListener('loadedmetadata', function() {
                progress.setAttribute('max', x.duration);

                // obtener duracion para input time
                var vidseg = x.duration;
                x.setAttribute("videoduration", x.duration);
                var minutos = Math.floor(vidseg / 60);
                var seconds = vidseg - minutos * 60;
                var hour = 0;
                if (10 > hour) {
                    hour = '0' + hour;
                }
                if (10 > minutos) {
                    minutos = '0' + minutos;
                }
                if (10 > seconds) {
                    seconds = '0' + seconds;
                }

                var res = hour + ":" + minutos + ":" + seconds;
                var videotime = res.substring(0, 8);

                document.getElementById("timeend").value = videotime;
                document.getElementById("timeinitial").value = "00:00:00";
                document.getElementById("timeinitial").max = videotime;

                x.addEventListener('volumechange', function() {
                    checkVolume();
                }, false);
            });

        } else {
            x.setAttribute("src", route);
            document.getElementById("Controls").style.display = "";
        }

        x.setAttribute("width", 240);
        x.setAttribute("height", 180);
        ev.target.append(x);

        son.parentNode.removeChild(son);

    }

    function droplink(ev) {
        ev.preventDefault();
        var data = ev.dataTransfer.getData("text");
        var son = document.getElementById(data);
        var x = document.createElement("a");
        var route = son.getAttribute("data-route");
        ev.target.target(obj);
    }
</script>

<!-- sidebar -->
<script>
    /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;

    for (i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    }
</script>


<!-- Borrar contenedor popup searchadvanced -->
<script>
    // Le añadimos función de borrar al botón
    function limpiaCampo() {
        // para una selección más general, se puede usar solo 'input'
        var elements = document.querySelectorAll("input[type='text']");
        // Por cada input field le añadimos una funcion 'onFocus'
        for (var i = 0; i < elements.length; i++) {
            elements[i].value = "";
        }
    }
</script>


<!-- //Controles de video -->
<script>
    // Display the user defined video controls
    var videoControls = document.getElementById('video-controls');
    var stop = document.getElementById('stop');
    var mute = document.getElementById('mute');
    var progress = document.getElementById('progress');
    var progressBar = document.getElementById('progress-bar');

    videoControls.setAttribute('data-state', 'visible');

    //funcionalidad de botones play pause mute
    var changeButtonState = function(type) {
        // Play/Pause button
        if (type == 'playpause') {
            var videos = document.querySelectorAll('[data-type="video"]');
            for (var v = 0; v < videos.length; v++) {
                var video = document.getElementById(videos[v].getAttribute("id"));
                if (video.paused || video.ended) {
                    playpause.setAttribute('data-state', 'play');
                } else {
                    playpause.setAttribute('data-state', 'pause');
                }
                if (type == 'mute') {
                    mute.setAttribute('data-state', video.muted ? 'unmute' : 'mute');
                }
            }

        }
        // Mute button

    }

    stop.addEventListener('click', function(e) {
        var videos = document.querySelectorAll('[data-type="video"]');
        for (var v = 0; v < videos.length; v++) {
            var video = videos[v];
            video.pause();
            video.currentTime = 0;
            progress.value = 0;
            // Update the play/pause button's 'data-state' which allows the correct button image to be set via CSS
            changeButtonState('playpause');
        }
    });

    mute.addEventListener('click', function(e) {
        var videos = document.querySelectorAll('[data-type="video"]');
        for (var v = 0; v < videos.length; v++) {
            var video = videos[v];
            video.muted = !video.muted;
            changeButtonState('mute');
        }
    });

    //navegador bloquea los elementos play pause
    playpause.addEventListener('click', function(e) {
        var videos = document.querySelectorAll('[data-type="video"]');
        for (var v = 0; v < videos.length; v++) {
            var video = videos[v];
            if (video.paused || video.ended) {
                video.play();
            } else {
                video.pause();
            }


            video.addEventListener('loadedmetadata', function() {
                progress.setAttribute('max', video.duration);
            });

            // As the video is playing, update the progress bar
            video.addEventListener('timeupdate', function() {
                // For mobile browsers, ensure that the progress element's max attribute is set
                if (!progress.getAttribute('max')) progress.setAttribute('max', video.duration);
                progress.value = video.currentTime;
                progressBar.style.width = Math.floor((video.currentTime / video.duration) * 100) + '%';
            });
        }
    });

    // React to the user clicking within the progress bar
    progress.addEventListener('click', function(e) {
        var videos = document.querySelectorAll('[data-type="video"]');
        for (var v = 0; v < videos.length; v++) {
            var video = videos[v];
            var pos = (e.pageX - this.offsetLeft) / this.offsetWidth;
            video.currentTime = pos * video.duration;
        }
    });

    var checkVolume = function(dir) {
        if (dir) {
            var currentVolume = Math.floor(video.volume * 10) / 10;
            if (dir === '+') {
                if (currentVolume < 1) video.volume += 0.1;
            } else if (dir === '-') {
                if (currentVolume > 0) video.volume -= 0.1;
            }
            // If the volume has been turned off, also set it as muted
            // Note: can only do this with the custom control set as when the 'volumechange' event is raised, there is no way to know if it was via a volume or a mute change
            if (currentVolume <= 0) video.muted = true;
            else video.muted = false;
        }
        changeButtonState('mute');
    }
    var alterVolume = function(dir) {
        checkVolume(dir);
    }
</script>

<!-- Limpiar videos de container -->
<script>
    function eliminarElemento() {
        location.reload();
    }
</script>
@endsection