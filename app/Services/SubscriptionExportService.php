<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use ZipArchive;

class SubscriptionExportService
{
    public function generateExcel(User $user): string
    {
        $subscriptions = $user->subscriptions()->with('category')->get();
        $totalMonthly = (float) $user->monthlyExpense();
        $totalYearly = (float) $user->yearlyExpense();
        $activeCount = $subscriptions->where('status', 'active')->count();

        $dateNow = Carbon::now()->translatedFormat('d F Y');
        $userName = $user->name;

        $tempFile = tempnam(sys_get_temp_dir(), 'tatagih_export_') . '.xlsx';

        $zip = new ZipArchive();
        if ($zip->open($tempFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new \RuntimeException('Gagal membuat file export Excel (.xlsx).');
        }

        $contentTypes = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
  <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
  <Default Extension="xml" ContentType="application/xml"/>
  <Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>
  <Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>
  <Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>
</Types>';

        $rels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>
</Relationships>';

        $wbRels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>
  <Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>
</Relationships>';

        $workbook = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
  <sheets>
    <sheet name="Daftar Langganan" sheetId="1" r:id="rId1"/>
  </sheets>
</workbook>';

        $styles = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">
  <numFmts count="1">
    <numFmt numFmtId="164" formatCode="&quot;Rp &quot;#,##0"/>
  </numFmts>
  <fonts count="5">
    <font><sz val="10"/><color rgb="FF1F2937"/><name val="Segoe UI"/></font>
    <font><b/><sz val="10"/><color rgb="FF111827"/><name val="Segoe UI"/></font>
    <font><b/><sz val="14"/><color rgb="FF0F172A"/><name val="Segoe UI"/></font>
    <font><sz val="9"/><color rgb="FF64748B"/><name val="Segoe UI"/></font>
    <font><b/><sz val="8.5"/><color rgb="FF475569"/><name val="Segoe UI"/></font>
  </fonts>
  <fills count="4">
    <fill><patternFill patternType="none"/></fill>
    <fill><patternFill patternType="gray125"/></fill>
    <fill><patternFill patternType="solid"><fgColor rgb="FFF1F5F9"/></patternFill></fill>
    <fill><patternFill patternType="solid"><fgColor rgb="FFFFFFFF"/></patternFill></fill>
  </fills>
  <borders count="4">
    <border><left/><right/><top/><bottom/><diagonal/></border>
    <border>
      <left style="thin"><color rgb="FFE2E8F0"/></left>
      <right style="thin"><color rgb="FFE2E8F0"/></right>
      <top style="thin"><color rgb="FFE2E8F0"/></top>
      <bottom style="thin"><color rgb="FFE2E8F0"/></bottom>
      <diagonal/>
    </border>
    <border>
      <left style="thin"><color rgb="FFCBD5E1"/></left>
      <right style="thin"><color rgb="FFCBD5E1"/></right>
      <top style="thin"><color rgb="FFCBD5E1"/></top>
      <bottom style="medium"><color rgb="FF94A3B8"/></bottom>
      <diagonal/>
    </border>
    <border>
      <left style="thin"><color rgb="FFCBD5E1"/></left>
      <right style="thin"><color rgb="FFCBD5E1"/></right>
      <top style="thin"><color rgb="FFCBD5E1"/></top>
      <bottom style="thin"><color rgb="FFCBD5E1"/></bottom>
      <diagonal/>
    </border>
  </borders>
  <cellStyleXfs count="1">
    <xf numFmtId="0" fontId="0" fillId="0" borderId="0"/>
  </cellStyleXfs>
  <cellXfs count="12">
    <xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/>
    <xf numFmtId="0" fontId="2" fillId="0" borderId="0" xfId="0" applyFont="1"><alignment horizontal="left" vertical="center"/></xf>
    <xf numFmtId="0" fontId="3" fillId="0" borderId="0" xfId="0" applyFont="1"><alignment horizontal="left" vertical="center"/></xf>
    <xf numFmtId="0" fontId="4" fillId="2" borderId="3" xfId="0" applyFont="1" applyFill="1" applyBorder="1"><alignment horizontal="center" vertical="center"/></xf>
    <xf numFmtId="0" fontId="1" fillId="3" borderId="3" xfId="0" applyFont="1" applyFill="1" applyBorder="1"><alignment horizontal="center" vertical="center"/></xf>
    <xf numFmtId="0" fontId="1" fillId="2" borderId="2" xfId="0" applyFont="1" applyFill="1" applyBorder="1"><alignment horizontal="center" vertical="center"/></xf>
    <xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0" applyFont="1" applyBorder="1"><alignment horizontal="left" vertical="center"/></xf>
    <xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0" applyFont="1" applyBorder="1"><alignment horizontal="center" vertical="center"/></xf>
    <xf numFmtId="164" fontId="0" fillId="0" borderId="1" xfId="0" applyNumberFormat="1" applyBorder="1"><alignment horizontal="right" vertical="center"/></xf>
    <xf numFmtId="0" fontId="1" fillId="2" borderId="2" xfId="0" applyFont="1" applyFill="1" applyBorder="1"><alignment horizontal="right" vertical="center"/></xf>
    <xf numFmtId="164" fontId="1" fillId="2" borderId="2" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyNumberFormat="1"><alignment horizontal="right" vertical="center"/></xf>
    <xf numFmtId="0" fontId="0" fillId="2" borderId="2" xfId="0" applyFill="1" applyBorder="1"/>
  </cellXfs>
</styleSheet>';

        $sheetXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">
  <cols>
    <col min="1" max="1" width="6" customWidth="1"/>
    <col min="2" max="2" width="28" customWidth="1"/>
    <col min="3" max="3" width="18" customWidth="1"/>
    <col min="4" max="4" width="20" customWidth="1"/>
    <col min="5" max="5" width="15" customWidth="1"/>
    <col min="6" max="6" width="20" customWidth="1"/>
    <col min="7" max="7" width="18" customWidth="1"/>
    <col min="8" max="8" width="14" customWidth="1"/>
    <col min="9" max="9" width="14" customWidth="1"/>
    <col min="10" max="10" width="18" customWidth="1"/>
  </cols>
  <sheetData>';

        $sheetXml .= '
    <row r="1" ht="26" customHeight="1">
      <c r="A1" s="1" t="inlineStr"><is><t>LAPORAN PORTOFOLIO LANGGANAN - TATAGIH</t></is></c>
    </row>';

        $sheetXml .= '
    <row r="2" ht="18" customHeight="1">
      <c r="A2" s="2" t="inlineStr"><is><t>Pengguna: ' . htmlspecialchars($userName, ENT_XML1, 'UTF-8') . '   |   Tanggal Ekspor: ' . $dateNow . '   |   Total Langganan Aktif: ' . $activeCount . ' Layanan</t></is></c>
    </row>';

        $sheetXml .= '
    <row r="3" ht="10" customHeight="1"/>';

        $sheetXml .= '
    <row r="4" ht="16" customHeight="1">
      <c r="A4" s="3" t="inlineStr"><is><t>TOTAL BEBAN BULANAN</t></is></c>
      <c r="B4" s="3"/>
      <c r="C4" s="3"/>
      <c r="D4" s="3" t="inlineStr"><is><t>PROYEKSI BEBAN TAHUNAN</t></is></c>
      <c r="E4" s="3"/>
      <c r="F4" s="3"/>
      <c r="G4" s="3" t="inlineStr"><is><t>STATUS PORTOFOLIO</t></is></c>
      <c r="H4" s="3"/>
      <c r="I4" s="3"/>
      <c r="J4" s="3"/>
    </row>';

        $sheetXml .= '
    <row r="5" ht="22" customHeight="1">
      <c r="A5" s="4" t="inlineStr"><is><t>Rp ' . number_format($totalMonthly, 0, ',', '.') . ' /bln</t></is></c>
      <c r="B5" s="4"/>
      <c r="C5" s="4"/>
      <c r="D5" s="4" t="inlineStr"><is><t>Rp ' . number_format($totalYearly, 0, ',', '.') . ' /thn</t></is></c>
      <c r="E5" s="4"/>
      <c r="F5" s="4"/>
      <c r="G5" s="4" t="inlineStr"><is><t>' . $activeCount . ' Layanan Aktif</t></is></c>
      <c r="H5" s="4"/>
      <c r="I5" s="4"/>
      <c r="J5" s="4"/>
    </row>';

        $sheetXml .= '
    <row r="6" ht="12" customHeight="1"/>';

        $sheetXml .= '
    <row r="7" ht="26" customHeight="1">
      <c r="A7" s="5" t="inlineStr"><is><t>No</t></is></c>
      <c r="B7" s="5" t="inlineStr"><is><t>Nama Layanan</t></is></c>
      <c r="C7" s="5" t="inlineStr"><is><t>Kategori</t></is></c>
      <c r="D7" s="5" t="inlineStr"><is><t>Nominal Tagihan</t></is></c>
      <c r="E7" s="5" t="inlineStr"><is><t>Siklus</t></is></c>
      <c r="F7" s="5" t="inlineStr"><is><t>Beban / Bulan</t></is></c>
      <c r="G7" s="5" t="inlineStr"><is><t>Jatuh Tempo</t></is></c>
      <c r="H7" s="5" t="inlineStr"><is><t>Auto-Renew</t></is></c>
      <c r="I7" s="5" t="inlineStr"><is><t>Status</t></is></c>
      <c r="J7" s="5" t="inlineStr"><is><t>Tanggal Mulai</t></is></c>
    </row>';

        $startRow = 8;
        $currentRow = 8;
        $rowNum = 1;

        foreach ($subscriptions as $sub) {
            $cycleLabel = match ($sub->billing_cycle) {
                'monthly' => 'Bulanan',
                'yearly' => 'Tahunan',
                'weekly' => 'Mingguan',
                'daily' => 'Harian',
                default => ucfirst($sub->billing_cycle)
            };

            $dueDate = 'Tiap Tgl ' . $sub->payment_date;
            if ($sub->next_payment_date) {
                $dueDate = Carbon::parse($sub->next_payment_date)->translatedFormat('d M Y');
            }

            $startDate = $sub->start_date ? Carbon::parse($sub->start_date)->translatedFormat('d/m/Y') : '-';

            $sheetXml .= '
    <row r="' . $currentRow . '" ht="20" customHeight="1">
      <c r="A' . $currentRow . '" s="7"><v>' . $rowNum . '</v></c>
      <c r="B' . $currentRow . '" s="6" t="inlineStr"><is><t>' . htmlspecialchars($sub->name, ENT_XML1, 'UTF-8') . '</t></is></c>
      <c r="C' . $currentRow . '" s="6" t="inlineStr"><is><t>' . htmlspecialchars($sub->category->name ?? 'Lainnya', ENT_XML1, 'UTF-8') . '</t></is></c>
      <c r="D' . $currentRow . '" s="8"><v>' . (float) $sub->amount . '</v></c>
      <c r="E' . $currentRow . '" s="7" t="inlineStr"><is><t>' . $cycleLabel . '</t></is></c>
      <c r="F' . $currentRow . '" s="8"><v>' . (float) $sub->monthly_amount . '</v></c>
      <c r="G' . $currentRow . '" s="7" t="inlineStr"><is><t>' . htmlspecialchars($dueDate, ENT_XML1, 'UTF-8') . '</t></is></c>
      <c r="H' . $currentRow . '" s="7" t="inlineStr"><is><t>' . ($sub->auto_renew ? 'Ya' : 'Tidak') . '</t></is></c>
      <c r="I' . $currentRow . '" s="7" t="inlineStr"><is><t>' . ($sub->status === 'active' ? 'Aktif' : 'Nonaktif') . '</t></is></c>
      <c r="J' . $currentRow . '" s="7" t="inlineStr"><is><t>' . htmlspecialchars($startDate, ENT_XML1, 'UTF-8') . '</t></is></c>
    </row>';

            $rowNum++;
            $currentRow++;
        }

        $endRow = $currentRow - 1;

        if ($subscriptions->count() > 0) {
            $sheetXml .= '
    <row r="' . $currentRow . '" ht="24" customHeight="1">
      <c r="A' . $currentRow . '" s="9" t="inlineStr"><is><t>TOTAL ESTIMASI BEBAN BULANAN :</t></is></c>
      <c r="B' . $currentRow . '" s="9"/>
      <c r="C' . $currentRow . '" s="9"/>
      <c r="D' . $currentRow . '" s="9"/>
      <c r="E' . $currentRow . '" s="9"/>
      <c r="F' . $currentRow . '" s="10"><f>SUM(F' . $startRow . ':F' . $endRow . ')</f><v>' . $totalMonthly . '</v></c>
      <c r="G' . $currentRow . '" s="11"/>
      <c r="H' . $currentRow . '" s="11"/>
      <c r="I' . $currentRow . '" s="11"/>
      <c r="J' . $currentRow . '" s="11"/>
    </row>';
        }

        $sheetXml .= '
  </sheetData>
  <mergeCells count="' . ($subscriptions->count() > 0 ? '6' : '5') . '">
    <mergeCell ref="A1:J1"/>
    <mergeCell ref="A2:J2"/>
    <mergeCell ref="A4:C4"/>
    <mergeCell ref="D4:F4"/>
    <mergeCell ref="G4:J4"/>
    <mergeCell ref="A5:C5"/>
    <mergeCell ref="D5:F5"/>
    <mergeCell ref="G5:J5"/>';

        if ($subscriptions->count() > 0) {
            $sheetXml .= '
    <mergeCell ref="A' . $currentRow . ':E' . $currentRow . '"/>
    <mergeCell ref="G' . $currentRow . ':J' . $currentRow . '"/>';
        }

        $sheetXml .= '
  </mergeCells>
</worksheet>';

        $zip->addFromString('[Content_Types].xml', $contentTypes);
        $zip->addFromString('_rels/.rels', $rels);
        $zip->addFromString('xl/_rels/workbook.xml.rels', $wbRels);
        $zip->addFromString('xl/workbook.xml', $workbook);
        $zip->addFromString('xl/styles.xml', $styles);
        $zip->addFromString('xl/worksheets/sheet1.xml', $sheetXml);

        $zip->close();

        return $tempFile;
    }
}
