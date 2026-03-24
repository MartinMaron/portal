<div style="color: #0284c7;">





    <h3>Brennstoffkosten</h3>
    <div>
        @foreach ($costs as $cost)
            <div>
                @php
                    $filteredAmounts = $cost->costAmounts->where(
                        'abrechnungssetting_id',
                        $realestate->abrechnungssetting->id,
                    );
                @endphp
                <table
                    style="width: 600px; border-collapse: collapse; margin-bottom: 10px; border-spacing: 0; border: 1px solid #000;">
                    <thead>
                        <tr>
                            <th colspan="{{ $cost->fueltype && $cost->fueltype->hasTank ? 5 : 4 }}"
                                style="text-align: center; border-bottom: 1px solid #000; padding: 5px;">
                                {{ $cost->caption }}
                            </th>
                        </tr>
                        <tr style="border-bottom: 1px solid #ddd;">
                            @if ($cost->fueltype && $cost->fueltype->hasTank)
                                <th style="text-align: center; padding: 0px;">
                                    Datum
                                </th>
                                <th style="text-align: center; padding: 0px;">
                                    CO2-Kosten</th>
                            @else
                                <th style="text-align: center; padding: 0px;">
                                    CO2-Kosten</th>
                            @endif
                            <th style="text-align: center; padding: 0px;">
                                CO2-Menge</th>
                            <th style="text-align: center; padding: 0px;">
                                Verbrauch</th>
                            <th style="text-align: center; padding: 0px;">
                                Betrag</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($filteredAmounts as $amount)
                            <tr>
                                @if ($cost->fueltype && $cost->fueltype->hasTank)
                                    <td style="text-align: center; padding: 0px;">
                                        {{ $amount->datum }}</td>
                                    <td style="text-align: center; padding: 0px;">
                                        {{ $amount->cobrutto }} €</td>
                                @else
                                    <td style="text-align: center; padding: 0px;">
                                        {{ $amount->cobrutto }} €</td>
                                @endif
                                <td style="text-align: center; padding: 0px;">
                                    {{ $amount->coconsupmtion }} kg</td>
                                <td style="text-align: center; padding: 0px;">
                                    {{ $amount->consumption_editing }} {{ $cost->fueltype->einheit->shortname }}</td>
                                <td style="text-align: center; padding: 0px;">
                                    {{ $amount->brutto }} €</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $cost->fueltype && $cost->fueltype->hasTank ? 5 : 4 }}"
                                    style="padding: 2px 4px;">Keine Einträge für diesen Zeitraum.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>

    <h3>Weitere Heizkosten</h3>
    <table
        style="width: 600px; border-collapse: collapse; margin-bottom: 10px; border-spacing: 0; border: 1px solid #000;">
        <thead>
            <tr style="border-bottom: 1px solid #ddd;">
                <th style="text-align: left; padding: 2px 4px;">Kostenart</th>
                <th style="text-align: right; padding: 2px 4px;">Betrag</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($heatingCosts as $cost)
                @php
                    $filteredAmounts = $cost->costAmounts->where(
                        'abrechnungssetting_id',
                        $realestate->abrechnungssetting->id,
                    );
                @endphp

                @if ($filteredAmounts->count() > 0)
                    <tr>
                        <td style="text-align: left; padding: 2px 4px;">{{ $cost->caption }}</td>
                        <td style="text-align: right; padding: 2px 4px;">
                            {{ $filteredAmounts->first()->brutto }} €
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <h3>Betriebskosten</h3>
    <table
        style="width: 600px; border-collapse: collapse; margin-bottom: 10px; border-spacing: 0; border: 1px solid #000;">
        <thead>
            <tr style="border: 1px solid #ddddddaf;">
                <th style="text-align: left; padding: 2px 4px;">Kostenart</th>
                <th style="text-align: right; padding: 2px 4px;">Betrag</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($operatingCosts->sortBy('caption') as $cost)
                @php
                    $filteredAmounts = $cost->costAmounts->where(
                        'abrechnungssetting_id',
                        $realestate->abrechnungssetting->id,
                    );
                @endphp

                @if ($filteredAmounts->count() > 0)
                    <tr>
                        <td style="text-align: left; padding: 2px 4px;">{{ $cost->caption }}</td>
                        <td style="text-align: right; padding: 2px 4px;">
                            {{ $filteredAmounts->first()->brutto }} €
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>


    <h3>Nutzerliste ({{ $realestate->abrechnungssetting->periodFrom->format('d.m.Y') }} -
        {{ $realestate->abrechnungssetting->periodTo->format('d.m.Y') }})</h3>
    <table
        style="width: 800px; border-collapse: collapse; margin-bottom: 10px; border-spacing: 0; border: 1px solid #000;">
        <thead>
            <tr style="border-bottom: 1px solid #ddd;">
                <th style="text-align: left; padding: 2px 4px; width: 60px;">NE</th>
                <th style="text-align: left; padding: 2px 4px;">Name</th>
                <th style="text-align: left; padding: 2px 4px; width: 80px;">Von</th>
                <th style="text-align: left; padding: 2px 4px; width: 80px;">Bis</th>
                <th style="text-align: right; padding: 2px 4px; width: 60px;">Fläche</th>
                <th style="text-align: right; padding: 2px 4px; width: 70px;">Vorausz.</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($realestate->occupants->sortBy('dateFrom')->sortBy('nutzeinheitNo') as $occupant)
                @php
                    $billStart = $realestate->abrechnungssetting->periodFrom;
                    $billEnd = $realestate->abrechnungssetting->periodTo;
                    $occStart = $occupant->dateFrom;
                    $occEnd = $occupant->dateTo;
                    $overlaps = false;
                    if ($occStart <= $billEnd && ($occEnd === null || $occEnd >= $billStart)) {
                        $overlaps = true;
                    }
                @endphp
                @if ($overlaps)
                    <tr>
                        <td style="text-align: left; padding: 2px 4px;">{{ $occupant->nutzeinheitNo }}</td>
                        <td style="text-align: left; padding: 2px 4px;">{{ $occupant->nachname }},
                            {{ $occupant->vorname }}</td>
                        <td style="text-align: left; padding: 2px 4px;">{{ $occupant->dateFrom->format('d.m.Y') }}</td>
                        <td style="text-align: left; padding: 2px 4px;">
                            {{ $occupant->dateTo ? $occupant->dateTo->format('d.m.Y') : '' }}</td>
                        <td style="text-align: right; padding: 2px 4px;">
                            {{ number_format($occupant->qmkc, 2, ',', '.') }} m²</td>
                        <td style="text-align: right; padding: 2px 4px;">{{ $occupant->vorauszahlung_editing }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
