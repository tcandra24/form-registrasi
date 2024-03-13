<div class="row mb-3">
    <div class="col-lg-12 d-flex align-items-strech">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">
                        {{ ucwords(request()->segment(1)) }}
                    </a>
                </li>
                @if (request()->segment(2))
                    <li class="breadcrumb-item">
                        <a href="#">
                            {{ ucwords(str_replace('-', ' ', request()->segment(2))) }}
                        </a>
                    </li>
                @endif
                @if (request()->segment(3))
                    <li class="breadcrumb-item">
                        <a href="#">
                            {{ ucwords(str_replace('-', ' ', request()->segment(3))) }}
                        </a>
                    </li>
                @endif
                @if (request()->segment(4))
                    <li class="breadcrumb-item">
                        <a href="#">
                            {{ ucwords(str_replace('-', ' ', request()->segment(4))) }}
                        </a>
                    </li>
                @endif
            </ol>
        </nav>
    </div>
</div>
