<html style="box-sizing: border-box;">
<head style="box-sizing: border-box;">
</head>
<body
    style="box-sizing: border-box;margin: 0;font-family: var(--bs-body-font-family);font-size: var(--bs-body-font-size);font-weight: var(--bs-body-font-weight);line-height: var(--bs-body-line-height);color: var(--bs-body-color);text-align: var(--bs-body-text-align);background-color: var(--bs-body-bg);-webkit-text-size-adjust: 100%;-webkit-tap-highlight-color: transparent;">

@include('includes.boostrap_css')

<div class="card border-0 shadow-lg m-4"
     style="box-sizing: border-box;--bs-card-spacer-y: 1rem;--bs-card-spacer-x: 1rem;--bs-card-title-spacer-y: 0.5rem;--bs-card-border-width: 1px;--bs-card-border-color: var(--bs-border-color-translucent);--bs-card-border-radius: 0.375rem;--bs-card-box-shadow: ;--bs-card-inner-border-radius: calc(0.375rem - 1px);--bs-card-cap-padding-y: 0.5rem;--bs-card-cap-padding-x: 1rem;--bs-card-cap-bg: rgba(0, 0, 0, 0.03);--bs-card-cap-color: ;--bs-card-height: ;--bs-card-color: ;--bs-card-bg: #fff;--bs-card-img-overlay-padding: 1rem;--bs-card-group-margin: 0.75rem;position: relative;display: flex;flex-direction: column;min-width: 0;height: var(--bs-card-height);word-wrap: break-word;background-color: var(--bs-card-bg);background-clip: border-box;border: 0!important;border-radius: var(--bs-card-border-radius);box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;margin: 1.5rem!important;">
    <div class="card-body" style="box-sizing: border-box;flex: 1 1 auto;padding: var(--bs-card-spacer-y) var(--bs-card-spacer-x);color: var(--bs-card-color);">
        <div class="row mb-3"
             style="box-sizing: border-box;--bs-gutter-x: 1.5rem;--bs-gutter-y: 0;display: flex;flex-wrap: wrap;margin-top: calc(-1 * var(--bs-gutter-y));margin-right: calc(-.5 * var(--bs-gutter-x));margin-left: calc(-.5 * var(--bs-gutter-x));margin-bottom: 1rem!important;">
            <div class="col"
                 style="box-sizing: border-box;flex-shrink: 0;width: 100%;max-width: 100%;padding-right: calc(var(--bs-gutter-x) * .5);padding-left: calc(var(--bs-gutter-x) * .5);margin-top: var(--bs-gutter-y);flex: 1 0 0%;">
                <label style="box-sizing: border-box;display: inline-block;">Address: </label>
                <div class="card"
                     style="box-sizing: border-box;--bs-card-spacer-y: 1rem;--bs-card-spacer-x: 1rem;--bs-card-title-spacer-y: 0.5rem;--bs-card-border-width: 1px;--bs-card-border-color: var(--bs-border-color-translucent);--bs-card-border-radius: 0.375rem;--bs-card-box-shadow: ;--bs-card-inner-border-radius: calc(0.375rem - 1px);--bs-card-cap-padding-y: 0.5rem;--bs-card-cap-padding-x: 1rem;--bs-card-cap-bg: rgba(0, 0, 0, 0.03);--bs-card-cap-color: ;--bs-card-height: ;--bs-card-color: ;--bs-card-bg: #fff;--bs-card-img-overlay-padding: 1rem;--bs-card-group-margin: 0.75rem;position: relative;display: flex;flex-direction: column;min-width: 0;height: var(--bs-card-height);word-wrap: break-word;background-color: var(--bs-card-bg);background-clip: border-box;border: var(--bs-card-border-width) solid var(--bs-card-border-color);border-radius: var(--bs-card-border-radius);">
                    <div class="card-body"
                         style="box-sizing: border-box;flex: 1 1 auto;padding: var(--bs-card-spacer-y) var(--bs-card-spacer-x);color: var(--bs-card-color);">
                        <pre
                            style="font-family: auto,serif;box-sizing: border-box;font-size: .875em;display: block;margin-top: 0;margin-bottom: 1rem;overflow: auto;">{{$verifiedAddress}}</pre>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3"
             style="box-sizing: border-box;--bs-gutter-x: 1.5rem;--bs-gutter-y: 0;display: flex;flex-wrap: wrap;margin-top: calc(-1 * var(--bs-gutter-y));margin-right: calc(-.5 * var(--bs-gutter-x));margin-left: calc(-.5 * var(--bs-gutter-x));margin-bottom: 1rem!important;">
            <div class="col"
                 style="box-sizing: border-box;flex-shrink: 0;width: 100%;max-width: 100%;padding-right: calc(var(--bs-gutter-x) * .5);padding-left: calc(var(--bs-gutter-x) * .5);margin-top: var(--bs-gutter-y);flex: 1 0 0%;">
                <label style="box-sizing: border-box;display: inline-block;">Package Weight: </label>
                <span style="box-sizing: border-box;">{{$rec->weight}} lbs (rounded)</span>
            </div>
        </div>
        <hr style="box-sizing: border-box;margin: 1rem 0;color: inherit;border: 0;border-top: 1px solid;opacity: .25;">
        <table class="table "
               style="box-sizing: border-box;caption-side: bottom;border-collapse: collapse;--bs-table-color: var(--bs-body-color);--bs-table-bg: transparent;--bs-table-border-color: var(--bs-border-color);--bs-table-accent-bg: transparent;--bs-table-striped-color: var(--bs-body-color);--bs-table-striped-bg: rgba(0, 0, 0, 0.05);--bs-table-active-color: var(--bs-body-color);--bs-table-active-bg: rgba(0, 0, 0, 0.1);--bs-table-hover-color: var(--bs-body-color);--bs-table-hover-bg: rgba(0, 0, 0, 0.075);width: 100%;margin-bottom: 1rem;color: var(--bs-table-color);vertical-align: top;border-color: var(--bs-table-border-color);">
            @foreach($paylist as $item)
                <tr style="box-sizing: border-box;border-color: inherit;border-style: solid;border-width: 0;">
                    <td style="box-sizing: border-box;border-color: inherit;border-style: solid;border-width: 0;">{{$item['name']}}</td>
                    <td style="box-sizing: border-box;border-color: inherit;border-style: solid;border-width: 0;">{{$item['description']}}</td>
                    <td class="text-end" style="box-sizing: border-box;border-color: inherit;border-style: solid;border-width: 0;text-align: right!important;">
                        {{\App\Helpers\StampHelper::priceFormat($item['value'])}}
                    </td>
                </tr>
            @endforeach
            <tfoot style="box-sizing: border-box;border-color: inherit;border-style: solid;border-width: 0;">
            <tr style="box-sizing: border-box;border-color: inherit;border-style: solid;border-width: 0;">
                <td style="box-sizing: border-box;border-color: inherit;border-style: solid;border-width: 0;padding: .5rem .5rem;background-color: var(--bs-table-bg);border-bottom-width: 1px;box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);">
                    <strong style="box-sizing: border-box;font-weight: bolder;">Total</strong></td>
                <td style="box-sizing: border-box;border-color: inherit;border-style: solid;border-width: 0;padding: .5rem .5rem;background-color: var(--bs-table-bg);border-bottom-width: 1px;box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);"></td>
                <td class="text-end"
                    style="box-sizing: border-box;border-color: inherit;border-style: solid;border-width: 0;padding: .5rem .5rem;background-color: var(--bs-table-bg);border-bottom-width: 1px;box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);text-align: right!important;">
                    <strong style="box-sizing: border-box;font-weight: bolder;">{{\App\Helpers\StampHelper::priceFormat($total)}}
                    </strong></td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
</body>
</html>
