<?php

namespace Database\Seeders;

use App\Models\LegalDocument;
use Illuminate\Database\Seeder;

/**
 * Yasal metinler: Gizlilik Politikası ve KVKK Aydınlatma Metni.
 * Slug'a göre updateOrCreate yapılır; tekrar çalıştırmak kayıt çoğaltmaz,
 * ancak paneldeki düzenlemelerin üzerine yazar.
 */
class LegalDocumentSeeder extends Seeder
{
    public function run(): void
    {
        LegalDocument::updateOrCreate(['slug' => 'gizlilik-politikasi'], [
            'title' => 'Gizlilik Politikası',
            'sort_order' => 1,
            'is_active' => true,
            'content' => $this->privacy(),
        ]);

        LegalDocument::updateOrCreate(['slug' => 'kvkk-aydinlatma-metni'], [
            'title' => 'KVKK Aydınlatma Metni',
            'sort_order' => 2,
            'is_active' => true,
            'content' => $this->kvkk(),
        ]);
    }

    private function privacy(): string
    {
        return <<<'HTML'
<p><strong>Son Güncelleme Tarihi: …… / …… / …………</strong></p>
<h2>Amaç ve Kapsam</h2>
<p>Bu Gizlilik Politikası, MİARGEM internet sitesini ziyaret edenlerin ve site üzerinden sunulan hizmetlerden yararlananların bilgilerinin korunmasına ilişkin esasları açıklamaktadır.</p>
<p>Politika; internet sitesi ziyareti, üyelik, iletişim, etkinlik kaydı, bülten aboneliği, Uzman ve Araştırmacı Havuzu ile İnsan Kaynakları ve Kariyer alanlarını kapsar. Kullanılan hizmete göre işlenen bilgiler ve kullanım amaçları farklılaşabilir. İlgili sürece ilişkin ayrıntılı bilgilendirme, kişisel verilerin toplandığı aşamada sunulan aydınlatma metinlerinde yapılır.</p>
<p>Siteyi İşleten Kişi veya Kuruluş: ……………………………………………………</p>
<h2>Gizliliğin Korunmasına İlişkin İlkelerimiz</h2>
<p>Kişisel verilerin hukuka ve dürüstlük kurallarına uygun, belirli ve açık amaçlarla kullanılmasını esas alırız. İşlenen bilgilerin amaçla bağlantılı, sınırlı ve ölçülü olmasına; doğru ve gerektiğinde güncel tutulmasına özen gösteririz.</p>
<p>Sunulan hizmet için gerekli olmayan bilgiler talep edilmez. Bir işlem kapsamında elde edilen bilgiler, uygun bir hukukî dayanak bulunmadıkça başka amaçlarla kullanılmaz. Bilgiler, mevzuatta öngörülen veya işleme amacı için gerekli olan süreyle sınırlı olarak saklanır.</p>
<h2>Kullanıcı Tarafından Paylaşılan Bilgiler</h2>
<p>Üyelik ve başvuru alanlarında ad, soyadı, iletişim bilgileri, kurum, görev, eğitim, meslekî deneyim ve başvurunun niteliğine uygun diğer bilgiler talep edilebilir. Zorunlu ve isteğe bağlı alanlar ilgili formlarda belirtilir.</p>
<p>Açıkça istenmedikçe kimlik belgesi, sağlık bilgisi, adli sicil kaydı veya diğer özel nitelikli kişisel veriler paylaşılmamalıdır. Öz geçmişlerde ve ek belgelerde, başvurunun değerlendirilmesiyle ilgisi bulunmayan kişisel bilgilere yer verilmemelidir.</p>
<p>Başka kişilere ait bilgi ve belgeler, bunların paylaşılması için gerekli yetki veya hukukî dayanak bulunmadan sisteme yüklenmemelidir.</p>
<h2>Üyelik ve Hesap Güvenliği</h2>
<p>Üyelik bilgileri, kullanıcı hesabının oluşturulması, giriş işlemlerinin yürütülmesi ve talep edilen üyelik hizmetlerinin sunulması amacıyla kullanılır.</p>
<p>Kullanıcılar, giriş bilgilerinin gizliliğini korumalı ve hesaplarının yetkisiz kişilerce kullanıldığını düşündüklerinde bizimle iletişime geçmelidir. Hesap ve sistem güvenliği için işlenen bilgilerin niteliğine uygun teknik ve idarî tedbirler alınır.</p>
<p>Üyelik oluşturulması; bülten gönderimine, profilin kamuya açık yayımlanmasına veya başvuru bilgilerinin başka kurumlarla paylaşılmasına kendiliğinden izin verildiği anlamına gelmez.</p>
<h2>Başvuruların ve Profillerin Gizliliği</h2>
<p>Uzman ve Araştırmacı Havuzu, Personel Talebi, Nakil Ağı ve İş / Staj Başvurusu alanlarında paylaşılan bilgiler, ilgili başvurunun amacı ve belirlenen erişim yetkileri çerçevesinde değerlendirilir.</p>
<p>Başvurunun sisteme kaydedilmesi, öz geçmişin veya iletişim bilgilerinin kamuya açık yayımlanmasına izin verildiği anlamına gelmez. Bilgilerin başka bir kurum veya çalışma ekibiyle paylaşılması gerektiğinde paylaşımın amacı, kapsamı ve hukukî dayanağı belirlenir. Gerekli bilgilendirme yapılır; açık rıza gereken hâllerde ayrı tercih alınır.</p>
<p>Başvuru yapılması, atama, nakil, görevlendirme, iş veya staj kabulü taahhüdü oluşturmaz.</p>
<h2>Etkinlik ve Bülten İletişimi</h2>
<p>Etkinlik kaydı sırasında verilen bilgiler; kayıt işlemlerinin yürütülmesi, katılımın düzenlenmesi, program değişikliklerinin bildirilmesi ve katılım bağlantılarının iletilmesi gibi etkinlikle doğrudan ilgili amaçlarla kullanılır.</p>
<p>Etkinliğe kayıt yaptırılması, bülten veya ilgisiz tanıtım gönderimlerine izin verildiği anlamına gelmez. Bülten aboneliği ayrı bir tercih olarak yürütülür. Kullanıcılar, gönderilerde sunulan yöntemle veya iletişim adresimiz üzerinden abonelikten çıkabilir.</p>
<h2>Çerezler ve Benzeri Teknolojiler</h2>
<p>İnternet sitesinde kullanılan çerezler ve benzeri teknolojiler; amaçları, sağlayıcıları, saklama süreleri ve hukukî dayanaklarıyla birlikte Çerez Aydınlatma Metninde açıklanır.</p>
<p>Hizmetin sunulması için kesinlikle gerekli çerezlerle tercihe bağlı çerezler birbirinden ayrılır. Açık rıza gerektiren çerezler, kullanıcı tercihinden önce etkinleştirilmez. Kullanıcıların tercihlerini değiştirmesine ve verdikleri rızayı geri almasına imkân sağlanır.</p>
<p>Çerez Aydınlatma Metni ve Tercih Yönetimi: ……………………………………………………</p>
<h2>Hizmet Sağlayıcılar ve Dış Bağlantılar</h2>
<p>Sitenin işletilmesi sırasında teknik hizmet sağlayıcılardan yararlanılması hâlinde, bu kişilerin bilgilere erişimi üstlendikleri işin gerektirdiği kapsamla sınırlandırılır. Gizlilik, erişim yetkileri ve veri güvenliği yükümlülükleri gözetilir.</p>
<p>Sitede başka internet sitelerine yönlendiren bağlantılar bulunabilir. Bağlantı verilen sitelerin kendi gizlilik ve kişisel veri uygulamaları geçerlidir. Bir bağlantıya yer verilmesi, kullanıcı bilgilerinin ilgili kuruluşa her amaçla aktarılmasına izin verildiği anlamına gelmez.</p>
<h2>Saklama ve Güvenlik</h2>
<p>Bilgiler, ilgili mevzuatta öngörülen veya işlendikleri amaç için gerekli olan süre boyunca saklanır. Saklamayı gerektiren sebepler ortadan kalktığında kişisel veriler, uygulanabilir koşullara göre silinir, yok edilir veya anonim hâle getirilir.</p>
<p>Yetkisiz erişimin, hukuka aykırı kullanımın ve veri kaybının önlenmesi için uygun teknik ve idarî tedbirler alınır. Erişim yetkileri, hizmet sağlayıcılarla ilişkiler ve güvenlik uygulamaları ihtiyaçlar doğrultusunda gözden geçirilir.</p>
<h2>Haklar ve İletişim</h2>
<p>Kişisel verilerinize ilişkin haklarınız ve başvuru yöntemleri, KVKK Aydınlatma Metninde açıklanmaktadır.</p>
<p>İletişim E-postası: ……………………………………………………<br>Telefon: ……………………………………………………<br>Yazışma Adresi: ……………………………………………………</p>
<p>Bu Politika güncellendiğinde yeni metin, güncelleme tarihiyle birlikte yayımlanır. Politika değişikliği, açık rıza gerektiren yeni bir işleme faaliyeti için kendiliğinden izin oluşturmaz.</p>
HTML;
    }

    private function kvkk(): string
    {
        return <<<'HTML'
<p><strong>Son Güncelleme Tarihi: …… / …… / …………</strong></p>
<h2>Veri Sorumlusu</h2>
<p>Bu metin, 6698 sayılı Kişisel Verilerin Korunması Kanunu kapsamında, MİARGEM internet sitesi üzerinden yürütülen kişisel veri işleme faaliyetleri hakkında bilgi vermek amacıyla hazırlanmıştır.</p>
<p>Veri Sorumlusunun Tam Adı veya Unvanı: ……………………………………………………<br>Adres: ……………………………………………………<br>E-posta: ……………………………………………………<br>Telefon: ……………………………………………………<br>KEP Adresi: ……………………………………………………</p>
<p>Bu metin, site üzerinden yürütülen işlemlere ilişkin genel aydınlatmayı içerir. Üyelik, etkinlik kaydı, kariyer veya uzmanlık başvurusu gibi süreçlerde, ilgili işleme özgü tamamlayıcı aydınlatmalar sunulur.</p>
<h2>İşlenebilecek Kişisel Veriler</h2>
<p>Kullandığınız hizmete ve tarafımıza ilettiğiniz bilgilere göre aşağıdaki veri kategorileri işlenebilir:</p>
<ul>
<li>a) <strong>Kimlik ve Profil Bilgileri:</strong> Ad, soyadı, kullanıcı hesabı ve profil bilgileri.</li>
<li>b) <strong>İletişim Bilgileri:</strong> E-posta adresi, telefon numarası ve işlemin gerektirdiği hâllerde yazışma adresi.</li>
<li>c) <strong>Meslekî ve Eğitim Bilgileri:</strong> Kurum, birim, unvan, fiilî görev, öğrenim, uzmanlık alanı, meslekî deneyim, öz geçmiş, yayın ve proje bağlantıları.</li>
<li>ç) <strong>Başvuru ve Talep Bilgileri:</strong> İletişim mesajları, personel ihtiyacı bildirimleri, görev yeri tercihleri, iş veya staj tercihleri ve uzmanlık katkısına ilişkin bilgiler.</li>
<li>d) <strong>Etkinlik Bilgileri:</strong> Kayıt yaptırılan etkinlik, katılım durumu ve etkinlik koşulları bakımından gerekli olması hâlinde MTS abonelik durumu.</li>
<li>e) <strong>İşlem Güvenliği Bilgileri:</strong> Kullanılan altyapının kaydettiği ölçüde IP adresi, erişim zamanı, oturum ve işlem kayıtları.</li>
<li>f) <strong>Tercih ve Başvuru Kayıtları:</strong> Bülten tercihleri, açık rıza ve rızanın geri alınması kayıtları ile kişisel verilere ilişkin talepler.</li>
</ul>
<p>Her kullanıcı bakımından bütün veri kategorileri işlenmez. İşleme faaliyeti, ilgili hizmetin gerektirdiği bilgilerle sınırlı yürütülür.</p>
<h2>Kişisel Verilerin Toplanma Yöntemleri</h2>
<p>Kişisel veriler; internet sitesi formları, üyelik ve başvuru ekranları, etkinlik kayıtları, kullanıcıların yüklediği belgeler, e-posta ve doğrudan iletişim kanalları üzerinden elde edilir.</p>
<p>Site kullanımı sırasında, kullanılan teknik altyapı ve çerezler aracılığıyla otomatik yollarla da veri toplanabilir. İşleme faaliyetleri tamamen veya kısmen otomatik yollarla ya da bir veri kayıt sisteminin parçası olmak kaydıyla otomatik olmayan yollarla yürütülebilir.</p>
<h2>İşleme Amaçları ve Hukukî Sebepler</h2>
<p>Kişisel veriler, aşağıdaki amaçlarla ve ilgili işlemin gerektirdiği kapsamda işlenir. Her süreçte uygulanacak hukukî sebep, ilgili form veya hizmete özgü tamamlayıcı aydınlatmada açıklanır.</p>
<h3>4.1. Üyelik İşlemleri</h3>
<p>Hesabın oluşturulması, kullanıcının doğrulanması ve talep edilen üyelik hizmetlerinin yürütülmesi için gerekli bilgiler; Kanunun 5. maddesinin ikinci fıkrasının (c) bendi kapsamında, sözleşmenin kurulması veya ifasıyla doğrudan ilgili olması ve gerekli bulunması şartıyla işlenir.</p>
<h3>4.2. İletişim Talepleri</h3>
<p>Soruların, görüşlerin ve taleplerin değerlendirilmesi ile cevaplandırılması amacıyla kimlik, iletişim ve mesaj bilgileri işlenir.</p>
<p>Bir sözleşmenin kurulması veya yürütülmesine ilişkin taleplerde Kanunun 5. maddesinin ikinci fıkrasının (c) bendi; diğer iletişim taleplerinde ise temel hak ve özgürlüklere zarar vermemek kaydıyla aynı fıkranın (f) bendindeki meşru menfaat şartı esas alınır.</p>
<h3>4.3. Etkinlik Kaydı ve Katılım</h3>
<p>Etkinliğe kayıt, katılımın düzenlenmesi, program bilgilerinin ve katılım bağlantılarının gönderilmesi için gerekli bilgiler; Kanunun 5. maddesinin ikinci fıkrasının (c) bendi kapsamında, katılım ilişkisinin kurulması veya ifası için gerekli olması şartıyla işlenir.</p>
<p>Etkinlikle ilgisi bulunmayan bülten ve tanıtım iletişimi bu kapsamda değerlendirilmez.</p>
<h3>4.4. İnsan Kaynakları ve Kariyer İşlemleri</h3>
<p>MİARGEM bünyesindeki belirli bir iş veya staj imkânına yapılan başvurularda gerekli aday bilgileri, Kanunun 5. maddesinin ikinci fıkrasının (c) bendi kapsamında sözleşme öncesi değerlendirme amacıyla işlenir.</p>
<p>Gelecekteki fırsatlar için aday havuzunda tutulma, nakil tercihlerinin başka kurumlara iletilmesi veya öz geçmişin dış kurumlarla paylaşılması işlemlerinde başka bir hukukî şart bulunmadığında, Kanunun 5. maddesinin birinci fıkrası kapsamında ayrı açık rıza alınır.</p>
<p>Kurumsal personel taleplerinde irtibat kişisine ait bilgiler, talebin değerlendirilmesi ve iletişimin yürütülmesiyle sınırlı kullanılır. İlgili işleme uygulanacak hukukî sebep Personel Talebi formunda açıklanır.</p>
<h3>4.5. Uzman ve Araştırmacı Havuzu</h3>
<p>Uzmanlık profilinin oluşturulması, gelecekteki araştırma ve proje ihtiyaçları için değerlendirilmesi ve uygun çalışmalar hakkında iletişim kurulması amacıyla meslekî ve iletişim bilgileri işlenir.</p>
<p>Başka bir işleme şartı bulunmayan havuz kayıtlarında Kanunun 5. maddesinin birinci fıkrası kapsamında açık rıza alınır. Belirli bir çalışma için sözleşme ilişkisinin kurulması hâlinde, bu ilişki için gerekli bilgiler aynı maddenin ikinci fıkrasının (c) bendi kapsamında işlenebilir.</p>
<p>Profilin kamuya açık yayımlanması veya başka bir veri sorumlusuyla paylaşılması, havuz kaydından ayrı değerlendirilir.</p>
<h3>4.6. Bülten Aboneliği</h3>
<p>Talep edilen yayın, faaliyet ve etkinlik duyurularının gönderilmesi için iletişim bilgileri, Kanunun 5. maddesinin birinci fıkrası kapsamında verilen açık rızaya dayanılarak işlenir. Abonelik tercihi geri alınabilir.</p>
<h3>4.7. Güvenlik, Hukukî Yükümlülükler ve Hakların Korunması</h3>
<p>Sistem güvenliğinin sağlanması ve kötüye kullanımın önlenmesi için gerekli kayıtlar, temel hak ve özgürlüklere zarar vermemek kaydıyla Kanunun 5. maddesinin ikinci fıkrasının (f) bendine dayanılarak işlenir.</p>
<p>Kanunî yükümlülüklerin yerine getirilmesi için gerekli işlemlerde aynı fıkranın (a) veya (ç) bentleri; bir hakkın tesisi, kullanılması veya korunması için gerekli işlemlerde ise (e) bendi uygulanır. İşleme faaliyeti, ilgili yükümlülük veya hakkın gerektirdiği kapsamla sınırlıdır.</p>
<h2>Kişisel Verilerin Aktarılması</h2>
<p>Kişisel veriler, ilgili amaç ve hukukî şartlarla sınırlı olarak aşağıdaki alıcı gruplarına aktarılabilir:</p>
<ul>
<li>a) <strong>Teknik Hizmet Sağlayıcılar:</strong> Sitenin barındırılması, bakımı, güvenliği ve iletişim altyapısının işletilmesi için gerekli bilgiler.</li>
<li>b) <strong>Etkinlik Hizmet Sağlayıcıları:</strong> Kayıt ve katılımın yürütülmesi için gerekli kimlik, iletişim ve katılım bilgileri.</li>
<li>c) <strong>Yetkili Kurum ve Makamlar:</strong> Kanunî yükümlülüklerin yerine getirilmesi veya usulüne uygun taleplerin karşılanması için gerekli bilgiler.</li>
<li>ç) <strong>Hukukî ve Meslekî Destek Sağlayıcıları:</strong> Hakların korunması ve yükümlülüklerin yerine getirilmesi için gerekli bilgiler.</li>
<li>d) <strong>Başvurunun Yöneltildiği Kurum veya Çalışma Ekibi:</strong> İlgili süreçte açıklanan amaç, kapsam ve hukukî şartlar çerçevesinde gerekli kimlik, iletişim ve meslekî bilgiler.</li>
</ul>
<p>Aktarımlar, Kanunun 8. maddesindeki şartlara uygun yürütülür. Açık rıza gereken paylaşımlarda ayrı tercih alınır. Başvurular ve öz geçmişler, belirsiz kişi veya kurumlara genel bir paylaşım izniyle gönderilmez.</p>
<p>Kullanılan Hizmet Sağlayıcılar ve İlgili Alıcı Grupları:<br>……………………………………………………………………………………<br>……………………………………………………………………………………</p>
<h2>Yurt Dışına Aktarım</h2>
<p>Yurt dışına aktarım yapılan işlemler bakımından aşağıdaki bilgiler esas alınır:</p>
<p>Aktarım Durumu: ……………………………………………………<br>Aktarılan Veri Kategorileri: ……………………………………………………<br>Aktarım Amacı: ……………………………………………………<br>Alıcı veya Alıcı Grubu: ……………………………………………………<br>Aktarım Yapılan Ülke veya Ülkeler: ……………………………………………………<br>Uygulanan Aktarım Mekanizması ve Güvence: ……………………………………………………</p>
<p>Yurt dışına aktarım, Kanunun 9. maddesinde öngörülen şartlar sağlanarak yürütülür. Yeterlilik kararı veya uygun güvenceye dayanan aktarımlar ile arızi aktarım istisnaları birbirinden ayrı değerlendirilir. Sürekli ve düzenli aktarım faaliyetleri, arızi aktarım istisnalarına dayandırılmaz.</p>
<h2>Saklama ve İmha</h2>
<p>Kişisel veriler, mevzuatın gerektirdiği veya işleme amacı için gerekli süre boyunca saklanır. Süreler belirlenirken ilişkinin devamı, başvurunun niteliği, kanunî yükümlülükler ve hakların korunması için gerekli süreler dikkate alınır.</p>
<table>
<thead>
<tr><th>Kayıt Grubu</th><th>Saklama Süresi</th></tr>
</thead>
<tbody>
<tr><td>Üyelik kayıtları</td><td>……………………………………………………</td></tr>
<tr><td>İletişim talepleri</td><td>……………………………………………………</td></tr>
<tr><td>Etkinlik kayıtları</td><td>……………………………………………………</td></tr>
<tr><td>İş / staj ve aday havuzu kayıtları</td><td>……………………………………………………</td></tr>
<tr><td>Nakil Ağı kayıtları</td><td>……………………………………………………</td></tr>
<tr><td>Uzman ve Araştırmacı Havuzu kayıtları</td><td>……………………………………………………</td></tr>
<tr><td>Bülten ve tercih kayıtları</td><td>……………………………………………………</td></tr>
<tr><td>İşlem güvenliği kayıtları</td><td>……………………………………………………</td></tr>
</tbody>
</table>
<p>İşleme şartlarının tamamı ortadan kalktığında veriler silinir, yok edilir veya anonim hâle getirilir. Açık rızanın geri alınması, başka bir hukukî sebebe dayanılarak saklanması gereken kayıtların kendiliğinden silinmesini gerektirmez.</p>
<h2>İlgili Kişinin Hakları</h2>
<p>Kanunun 11. maddesi kapsamında veri sorumlusuna başvurarak:</p>
<ul>
<li>a) Kişisel verilerinizin işlenip işlenmediğini öğrenebilir,</li>
<li>b) İşlenmişse buna ilişkin bilgi talep edebilir,</li>
<li>c) İşlenme amacını ve amacına uygun kullanılıp kullanılmadığını öğrenebilir,</li>
<li>ç) Yurt içinde veya yurt dışında aktarıldığı üçüncü kişileri öğrenebilir,</li>
<li>d) Eksik veya yanlış işlenmiş verilerin düzeltilmesini isteyebilir,</li>
<li>e) Kanunda öngörülen şartlarla silinmesini veya yok edilmesini talep edebilir,</li>
<li>f) Düzeltme, silme veya yok etme işlemlerinin verilerin aktarıldığı üçüncü kişilere bildirilmesini isteyebilir,</li>
<li>g) Münhasıran otomatik sistemlerle yapılan analiz sonucunda aleyhinize bir sonuç ortaya çıkmasına itiraz edebilir,</li>
<li>ğ) Verilerin kanuna aykırı işlenmesi nedeniyle zarara uğramanız hâlinde zararın giderilmesini talep edebilirsiniz.</li>
</ul>
<h2>Başvuru Yöntemleri</h2>
<p>Haklarınıza ilişkin taleplerinizi aşağıdaki kanallardan iletebilirsiniz:</p>
<p>Yazılı Başvuru Adresi: ……………………………………………………<br>KEP Adresi: ……………………………………………………<br>E-posta Adresi: ……………………………………………………<br>Varsa Elektronik Başvuru Sistemi: ……………………………………………………</p>
<p>Başvurular; yazılı olarak, KEP, güvenli elektronik imza, mobil imza veya mevzuatta öngörülen diğer yöntemlerle yapılabilir. Normal e-posta yoluyla başvuruda, tarafımıza daha önce bildirdiğiniz ve sistemimizde kayıtlı bulunan e-posta adresinizi kullanmanız gerekir.</p>
<p>Başvuruda ad ve soyadı, yazılı başvurularda imza, Türkiye Cumhuriyeti vatandaşları için T.C. kimlik numarası, yabancılar için uyruğu ve pasaport numarası veya varsa kimlik numarası, tebligata esas yerleşim yeri veya iş yeri adresi, varsa bildirime esas e-posta adresi, telefon ve faks numarası ile talep konusu bulunmalıdır. Konuyla ilgili bilgi ve belgeler başvuruya eklenebilir.</p>
<p>Başvurular, talebin niteliğine göre en kısa sürede ve en geç otuz gün içinde sonuçlandırılır. İşlemin ayrıca bir maliyet gerektirmesi hâlinde Kişisel Verileri Koruma Kurulunca belirlenen tarife uygulanabilir.</p>
<h2>Aydınlatma ve Açık Rıza Ayrımı</h2>
<p>Bu metin bilgilendirme amacı taşır. Metnin okunması, internet sitesinin kullanılması veya üyelik oluşturulması, bütün kişisel veri işleme faaliyetlerine açık rıza verildiği anlamına gelmez.</p>
<p>Açık rıza gereken işlemler, amaç ve kapsamları belirtilerek ayrı tercihlerle sunulur. Bülten aboneliği, dış kurumlara profil aktarımı ve kamuya açık profil yayını gibi farklı işlemler tek bir zorunlu onay altında birleştirilmez.</p>
<p>Verilen açık rıza, yukarıdaki iletişim kanalları veya ilgili hizmette sunulan tercih araçları üzerinden geri alınabilir. Geri alma, bildirimin ulaşmasından sonraki işlemler bakımından sonuç doğurur; önceki işlemlerin hukukî durumunu kendiliğinden değiştirmez.</p>
HTML;
    }
}
