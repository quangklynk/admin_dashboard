using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;

namespace CHUNGKHOAN
{
    public partial class frmMain : DevExpress.XtraBars.Ribbon.RibbonForm
    {
        public void HienThiMenu()
        {
            MANV.Text = "Mã NV : " + Program.username;
            HOTEN.Text = "Họ Tên : " + Program.mHoten;
            NHOM.Text = "Nhóm : " + Program.mGroup;

            rib_CT.Visible = rib_NDT.Visible = rib_SGD.Visible = true;
        }

        private Form CheckExists(Type ftype)
        {
            foreach (Form f in this.MdiChildren)
                if (f.GetType() == ftype)
                    return f;
            return null;
        }

        public frmMain()
        {
            InitializeComponent();
        }

        private void barButtonLogin_ItemClick(object sender, DevExpress.XtraBars.ItemClickEventArgs e)
        {
            Form frm = this.CheckExists(typeof(frmLogin));
            if (frm != null)
            {
                frm.Activate();
            }
            else
            {
                frmLogin f = new frmLogin();
                f.MdiParent = this;
                f.Show();
            }
        }
    }
}
