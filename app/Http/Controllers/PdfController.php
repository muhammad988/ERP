<?php

namespace App\Http\Controllers;

use PDF;
use View;
use App\Model\Service\Service;

/**
 * Class PdfController
 * @package App\Http\Controllers
 */
class PdfController extends PDF
{
    /**
     * @param $id
     */
    public function print_pyr ($id): void
    {
        $service = Service::with ('notification.user_receiver', 'service_items.item', 'service_items.unit', 'service_items.detailed_proposal_budget.category_option', 'project', 'currency')->find ($id);
        $name = null;
        if ($service->recipient) {
            $name = $service->service_recipient->first_name_en . ' ' . $service->service_recipient->last_name_en;
        } elseif ($service->implementing_partner_id) {
            $name = $service->implementing_partner->name_en;
        } elseif ($service->supplier_id) {
            $name = $service->supplier->name_en;
        } else {
            $name = $service->service_provider->name_en;
        }
        $bank_info = null;
        if ($service->implementing_partner_account_id) {
            $bank_info = $service->implementing_partner_account;
        }
        if ($service->supplier_account_id) {
            $bank_info = $service->supplier_account;
        }
        if ($service->service_provider_account_id) {
            $bank_info = $service->service_provider_account;
        }
        if ($service->payment_method_id == 3296) {

            if ($service->payment_type_id == 310675) {
                $title = 'طلب صرف و امر صرف ( نقدي )- تحويل بنكي <br> Payment Request - Order ( Direct ) - Bank transfer';
            } else {
                $title = 'طلب صرف و امر صرف ( نقدي ) <br> Payment Request - Order ( Direct )';
            }
            $currency = ['87035' => 1, '87036' => 2, '87034' => 3];

            $view = View::make ('pdf.services.pyr_direct', compact ('service', 'currency', 'name', 'title', 'bank_info'));
        } else {
            if ($service->payment_type_id == 310675) {
                $title = 'طلب صرف  و امر صرف ( عهدة )- تحويل بنكي <br> Payment Request - Order ( Advance ) - Bank transfer';
            } else {
                $title = 'طلب صرف  و امر صرف ( عهدة ) <br> Payment Request - Order ( Advance )';
            }
            $view = View::make ('pdf.services.pyr_advance', compact ('service', 'name', 'title', 'bank_info'));
        }
        // usersPdf is the view that includes the downloading content
        $html_content = $view->render ();
        // Set title in the PDF
        PDF::setHeaderCallback (
            function($pdf) {
                $image_file = K_PATH_IMAGES . 'qrcs_heading.jpg';
                PDF::Image ($image_file, 13, 2, 271, '', 'jpg', '', 'T', false, 0, '', false, false, 0, false, false, false);
            }
        );
        PDF::SetMargins (PDF_MARGIN_LEFT, 18, PDF_MARGIN_RIGHT);
// set image scale factor
        PDF::setImageScale (PDF_IMAGE_SCALE_RATIO);
        PDF::AddPage ('L', 'A4');
        PDF::setFooterCallback (
            function($pdf) {
                $pdf->SetY (-15);
                // Page number
                $pdf->Cell (0, 10, 'Page ' . PDF::getAliasNumPage () . ' OF ' . PDF::getAliasNbPages (), 0, false, 'R', 0, '', 0, false, 'T', 'M');
            }
        );
        $font_name = 'helveticaneueltarabiclight';
        // set certificate file
//      $certificate = 'file://' . K_PATH_MAIN . 'examples/data/test_2/server.crt';
        $private_key = 'file://' . K_PATH_MAIN . 'examples/data/cert/k.key';
        $certificate = 'file://' . K_PATH_MAIN . 'examples/data/cert/c.crt';

// set additional information
        $info = array(
            'Name'     => 'ERP',
            'Location' => 'tr',
            'Reason'   => 'Testing ERP',
        );
// set document signature
        PDF::SetAuthor ('ERP');
        PDF::SetTitle ('PYR pdf');
        PDF::SetSubject ('PYR pdf');
        PDF::SetFont ($font_name, '', 7);
        PDF::writeHTML ($html_content, true, false, false, false, '');
        //Close and output PDF document
        PDF::setSignature ($certificate, $certificate, '', '', 1, $info);
        //        PDF::setSignatureAppearance(16, 10, 25, 25,'','test');
        //        PDF::Image (K_PATH_MAIN . 'examples/images/tcpdf_signature.png', 16, 10, 15, 15, 'PNG');
        PDF::AddPage ('L', 'A4');
        PDF::setSignatureAppearance (150, 48, 140, 120, '', 'test');
        //        PDF::Image (K_PATH_MAIN . 'examples/images/tcpdf_signature.png', 150, 48, 140, 120, 'PNG');
        PDF::SetFont ($font_name, '', 15);
        PDF::Cell (0, 0, 'التواقيع', 0, 1, 'C');
        PDF::Cell (0, 0, 'Signature', 0, 1, 'C');
        PDF::Cell (0, 0, '', 0, 1, 'C');
        PDF::SetFont ($font_name, '', 10);
        $signature_tr = '';
        foreach ($service->notification as $key => $signer) {
            PDF::Image (K_PATH_MAIN . 'examples/images/tcpdf_signature.png', 200, 50 + ($key * 11), 40, 9, 'PNG');
            $signature_tr .= '<tr>
                              <td>' . ++$key . '</td>
                              <td>' . $signer->user_receiver->full_name . '</td>
                              <td>' . $signer->user_receiver->email . '</td>
                              <td height="40">' . $signer->user_receiver->signeture . '</td>
                           </tr>';
        }
        $tbl3 = '<table cellspacing="0" cellpadding="3" border="1" style="text-align:center;">
     <tr style="background-color:#e1e0dd;">
            <th width="2%">#</th>
            <th width="24%">Name<br>اسم</th>
            <th width="24%">Email<br>اسم</th>
            <th width="50%">Signature<br>توقيع</th>
        </tr>
         ' . $signature_tr . '
</table>';
        PDF::writeHTML ($tbl3, true, false, false, false, '');
        // *** set an empty signature appearance ***
        PDF::Output ($service->code . '.pdf', 'I');
    }
    /**
     * @param $id
     */
    //payment-order
    public function print_pyo ($id): void
    {
        $service = Service::with ('service_items.item', 'service_itemss.unit', 'service_itemss.detailed_proposal_budget.category_option', 'project', 'currency')->find ($id);
        $name = null;
        if ($service->recipient) {
            $name = $service->service_recipient->first_name_en . ' ' . $service->service_recipient->last_name_en;
        } elseif ($service->implementing_partner_id) {
            $name = $service->implementing_partner->name_en;
        } elseif ($service->supplier_id) {
            $name = $service->supplier->name_en;
        } else {
            $name = $service->service_provider->name_en;
        }//
        $bank_info = null;
        if ($service->implementing_partner_account_id) {
            $bank_info = $service->implementing_partner_account;
        }
        if ($service->supplier_account_id) {
            $bank_info = $service->supplier_account;
        }
        if ($service->service_provider_account_id) {
            $bank_info = $service->service_provider_account;
        }

        $title = 'أمر صرف نقدي ( مباشر ) <br> Payment Order -  ( Direct )';
        $currency = ['87035' => 1, '87036' => 2, '87034' => 3];
        $view = View::make ('pdf.services.clearance ', compact ('service', 'name', 'currency', 'title', 'bank_info'));
        // usersPdf is the view that includes the downloading content
//        print_r ($view);
        $html_content = $view->render ();
        // Set title in the PDF
        PDF::setHeaderCallback (
            function($pdf) {
                $image_file = K_PATH_IMAGES . 'qrcs_heading.jpg';
                PDF::Image ($image_file, 13, 2, 271, '', 'jpg', '', 'T', false, 0, '', false, false, 0, false, false, false);
            }
        );
        PDF::SetMargins (PDF_MARGIN_LEFT, 18, PDF_MARGIN_RIGHT);
//// set image scale factor
        PDF::setImageScale (PDF_IMAGE_SCALE_RATIO);
        PDF::AddPage ('L', 'A4');

        PDF::setFooterCallback (
            function($pdf) {
                $pdf->SetY (-15);
                // Page number
                $pdf->Cell (0, 10, 'Page ' . PDF::getAliasNumPage () . ' OF ' . PDF::getAliasNbPages (), 0, false, 'R', 0, '', 0, false, 'T', 'M');
            }
        );
        $font_name = 'helveticaneueltarabiclight';
        // set certificate file
        $certificate = 'file://' . K_PATH_MAIN . 'examples/data/test_2/server.crt';
        $privatekey = 'file://' . K_PATH_MAIN . 'examples/data/test_2/server.key';
//        echo 'file://' . K_PATH_MAIN . 'examples/data/test/CertExchange.cer';
//        var_dump(openssl_get_publickey('' . K_PATH_MAIN . 'examples/data/test/CertExchange.cer'));

// set additional information
        $info = array(
            'Name'        => 'TCPDF',
            'Location'    => 'Office',
            'Reason'      => 'Testing TCPDF',
            'ContactInfo' => 'http://www.tcpdf.org',
        );

// set document signature

//        PDF::addEmptySignatureAppearance(200, 150, 20, 20);
        PDF::SetAuthor ('ERP');
        PDF::SetTitle ('PYR pdf');
        PDF::SetSubject ('PYR pdf');
        PDF::SetFont ($font_name, '', 7);
        PDF::writeHTML ($html_content, true, false, false, false, '');
//Close and output PDF document

        PDF::setSignature ($certificate, $privatekey, '', '', 2, $info);
        PDF::setSignatureAppearance (220, 170, 50, 50);
//
//        PDF::setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
//        PDF::Image (K_PATH_MAIN . 'examples/images/tcpdf_signature.png', 220, 170, 50, 50, 'PNG');
//        PDF::Image (K_PATH_MAIN . 'examples/images/tcpdf_f_signature.png', 200, 150, 15, 15, 'PNG');
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // *** set an empty signature appearance ***
        PDF::Output ($service->code . '.pdf', 'I');
    }

    /**
     * @param $id
     */
    public function print_cl ($id): void
    {
        $service = Service::with ('service_itemss.item', 'service_itemss.unit', 'service_itemss.detailed_proposal_budget.category_option', 'project', 'currency')->find ($id);
        $name = null;
        if ($service->recipient) {
            $name = $service->service_recipient->first_name_en . ' ' . $service->service_recipient->last_name_en;
        } elseif ($service->implementing_partner_id) {
            $name = $service->implementing_partner->name_en;
        } elseif ($service->supplier_id) {
            $name = $service->supplier->name_en;
        } else {
            $name = $service->service_provider->name_en;
        }
        $bank_info = null;
        if ($service->implementing_partner_account_id) {
            $bank_info = $service->implementing_partner_account;
        }
        if ($service->supplier_account_id) {
            $bank_info = $service->supplier_account;
        }
        if ($service->service_provider_account_id) {
            $bank_info = $service->service_provider_account;
        }
        $title = 'كشف تسوية عهدة مالية <br> Clearance Of Advance';
        $currency = ['87035' => 1, '87036' => 2, '87034' => 3];
        $view = View::make ('pdf.services.clearance ', compact ('service', 'name', 'currency', 'title', 'bank_info'));
        // usersPdf is the view that includes the downloading content
        $html_content = $view->render ();
        // Set title in the PDF
        PDF::setHeaderCallback (
            function($pdf) {
                $image_file = K_PATH_IMAGES . 'qrcs_heading.jpg';
                PDF::Image ($image_file, 13, 2, 271, '', 'jpg', '', 'T', false, 0, '', false, false, 0, false, false, false);
            }
        );
        PDF::SetMargins (PDF_MARGIN_LEFT, 18, PDF_MARGIN_RIGHT);
//// set image scale factor
        PDF::setImageScale (PDF_IMAGE_SCALE_RATIO);
        PDF::AddPage ('L', 'A4');
        $view_pyr = View::make ('pdf.services.signature', compact ('service'));

        PDF::setFooterCallback (
            function($pdf) {
                $pdf->SetY (-15);
                // Page number
                $pdf->Cell (0, 10, 'Page ' . PDF::getAliasNumPage () . ' OF ' . PDF::getAliasNbPages (), 0, false, 'R', 0, '', 0, false, 'T', 'M');
            }
        );
        $font_name = 'helveticaneueltarabiclight';
        // set certificate file
//        $certificate = 'file://' . K_PATH_MAIN . 'examples/data/test_2/server.crt';
//        $privatekey = 'file://' . K_PATH_MAIN . 'examples/data/test_2/server.key';
//        echo 'file://' . K_PATH_MAIN . 'examples/data/test/CertExchange.cer';
//        var_dump(openssl_get_publickey('' . K_PATH_MAIN . 'examples/data/test/CertExchange.cer'));

// set additional information
        $info = array(
            'Name'        => 'TCPDF',
            'Location'    => 'Office',
            'Reason'      => 'Testing TCPDF',
            'ContactInfo' => 'http://www.tcpdf.org',
        );

// set document signature

//        PDF::addEmptySignatureAppearance(200, 150, 20, 20);
        PDF::SetAuthor ('ERP');
        PDF::SetTitle ('PYR pdf');
        PDF::SetSubject ('PYR pdf');
        PDF::SetFont ($font_name, '', 7);
        PDF::writeHTML ($html_content, true, false, false, false, '');
//Close and output PDF document

//        PDF::setSignature ($certificate, $privatekey, '', '', 2, $info);
//        PDF::setSignatureAppearance(220, 170, 50, 50);
//
//        PDF::setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
//        PDF::Image (K_PATH_MAIN . 'examples/images/tcpdf_signature.png', 220, 170, 50, 50, 'PNG');
//        PDF::Image (K_PATH_MAIN . 'examples/images/tcpdf_f_signature.png', 200, 150, 15, 15, 'PNG');
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // *** set an empty signature appearance ***
        PDF::Output ($service->code . '.pdf', 'I');
    }

    /**
     * @param $id
     */
    public function print_po ($id): void
    {
        $service = Service::with ('service_items.item', 'service_items.unit', 'service_items.detailed_proposal_budget.category_option', 'project', 'currency')->find ($id);
        $name = null;
        if ($service->recipient) {
            $name = $service->service_recipient->first_name_en . ' ' . $service->service_recipient->last_name_en;
        } elseif ($service->implementing_partner_id) {
            $name = $service->implementing_partner->name_en;
        } elseif ($service->supplier_id) {
            $name = $service->supplier->name_en;
        } else {
            $name = $service->service_provider->name_en;
        }
        $bank_info = null;
        if ($service->implementing_partner_account_id) {
            $bank_info = $service->implementing_partner_account;
        }
        if ($service->supplier_account_id) {
            $bank_info = $service->supplier_account;
        }
        if ($service->service_provider_account_id) {
            $bank_info = $service->service_provider_account;
        }
        if ($service->payment_method_id == 3296 && $service->service_type_id == 375447) {
            if ($service->payment_type_id == 310675) {
                $title = 'طلب صرف و امر صرف ( نقدي )- تحويل بنكي <br> Payment Request - Order ( Direct ) - Bank transfer';
            } else {
                $title = 'طلب صرف و امر صرف ( نقدي ) <br> Payment Request - Order ( Direct )';
            }
            $title_2 = 'طلب شراء <br> Purchase Request';
            $title_3 = 'أمر شراء <br> Purchase Order ( Direct ) ';
            $currency = ['87035' => 1, '87036' => 2, '87034' => 3];
            $view_pyr = View::make ('pdf.services.pyr_direct', compact ('service', 'currency', 'name', 'title', 'bank_info'));

        } else {
            if ($service->payment_type_id == 310675) {
                $title = 'طلب صرف  و امر صرف ( عهدة )- تحويل بنكي <br> Payment Request - Order ( Advance ) - Bank transfer';
            } else {
                $title = 'طلب صرف  و امر صرف ( عهدة ) <br> Payment Request - Order ( Advance )';
            }
            $view_pyr = View::make ('pdf.services.pyr_advance', compact ('service', 'name', 'title', 'bank_info'));
            $title_2 = 'طلب شراء <br> Purchase Request';
            $title_3 = 'أمر شراء <br> Purchase Order ( Advance ) ';
        }
        $view_request = View::make ('pdf.services.purchase_request', compact ('service', 'name', 'title_2', 'bank_info'));
        $html_request = $view_request->render ();
        $view_order = View::make ('pdf.services.purchase_order', compact ('service', 'name', 'title_3', 'bank_info'));
        $html_order = $view_order->render ();
        $html_pyr = $view_pyr->render ();
        // Set title in the PDF
        PDF::setHeaderCallback (
            function($pdf) {
                $image_file = K_PATH_IMAGES . 'qrcs_heading.jpg';
                PDF::Image ($image_file, 13, 2, 271, '', 'jpg', '', 'T', false, 0, '', false, false, 0, false, false, false);
            }
        );
        PDF::SetMargins (PDF_MARGIN_LEFT, 18, PDF_MARGIN_RIGHT);
        // set image scale factor
        PDF::setImageScale (PDF_IMAGE_SCALE_RATIO);
        PDF::AddPage ('L', 'A4');
        PDF::setFooterCallback (
            function($pdf) {
                $pdf->SetY (-15);
                $pdf->Cell (0, 10, 'Page ' . PDF::getAliasNumPage () . ' OF ' . PDF::getAliasNbPages (), 0, false, 'R', 0, '', 0, false, 'T', 'M');
            }
        );
        $font_name = 'helveticaneueltarabiclight';
        // set certificate file
        $certificate = 'file://' . K_PATH_MAIN . 'examples/data/test/server.crt';
//        $certificate = 'file://C:\xampp\htdocs\erp_laravel_6\vendor\tecnickcom\tcpdf/examples/data/cert/tcpdf.crt';
// set additional information
        $info = array(
            'Name'        => 'TCPDF',
            'Location'    => 'Office',
            'Reason'      => 'Testing TCPDF',
            'ContactInfo' => 'http://www.tcpdf.org',
        );
// set document signature
        PDF::setSignature ($certificate, $certificate, 'tcpdfdemo', '', 2, $info);
//        PDF::setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
        PDF::Image (K_PATH_MAIN . 'examples/images/tcpdf_signature.png', 265, 170, 15, 15, 'PNG');
        PDF::SetAuthor ('ERP');
        PDF::SetTitle ('PYR pdf');
        PDF::SetSubject ('PYR pdf');
        PDF::SetFont ($font_name, '', 7);

        PDF::writeHTML ($html_request, true, false, false, false, '');
        PDF::AddPage ('L', 'A4');
        PDF::writeHTML ($html_order, true, false, false, false, '');
        PDF::AddPage ('L', 'A4');
        PDF::writeHTML ($html_pyr, true, false, false, false, '');
        PDF::Output ($service->code . '.pdf', 'I');

    }
}
