<?php

namespace Database\Seeders;

use App\Models\CorporateSection;
use Illuminate\Database\Seeder;

/**
 * Kurumsal sayfasının (önceden statik Blade) tüm bölümleri ve alt içerikleri.
 * Slug'a göre updateOrCreate yapılır; tekrar çalıştırmak kayıt çoğaltmaz.
 */
class CorporateSectionSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->sections() as $section) {
            CorporateSection::updateOrCreate(['slug' => $section['slug']], $section);
        }
    }

    private function sections(): array
    {
        return [
            [
                'title' => 'Kurumsal Kimlik ve Hakkımızda',
                'slug' => 'kurumsal-kimlik',
                'display_type' => 'standard',
                'content' => '<p>MİARGEM, başta belediyeler olmak üzere mahallî idarelerin hukukî, idarî, malî ve beşerî yapısını birlikte inceleyen bağımsız bir araştırma ve geliştirme merkezidir. Akademik bilgi ile saha deneyimini buluşturarak ortak sorunların nedenlerini ve etkilerini araştırır; karar süreçlerinde yararlanılabilecek politika, mevzuat ve yönetim önerileri geliştirir.</p>
<p>Çalışma alanımız belediyeleri, il özel idarelerini, köyleri, mahallî idare birliklerini ve ilgili bağlı kuruluşları kapsar. Kurumların görev ve yetkileriyle kaynakları arasındaki dengeyi, teşkilat ve insan kaynağı yapılarını ve hizmet üretme kapasitelerini kamu yararı çerçevesinde ele alırız. Seçilmiş görevliler ile atanmış yöneticilerin ve personelin ortak ihtiyaçlarını bu bütünlük içinde değerlendiririz.</p>
<p>Mahallî idarelerin ortak kurumsal hak ve menfaatlerini; hukukî güvenlik, hizmetlerin sürekliliği ve vatandaşların nitelikli hizmetlere erişimi temelinde savunuruz. Kurumların deneyimlerini ortak bilgiye dönüştürmeyi, araştırma bulgularının uygulanabilir önerilere ve kurumsal gelişime katkı sağlamasını amaçlarız.</p>',
                'items' => [
                    [
                        'title' => 'MİARGEM | Mahallî İdareler Araştırma ve Geliştirme Merkezi',
                        'subtitle' => null,
                        'description' => null,
                    ],
                ],
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Tarihçe ve Kurumsal Birikim',
                'slug' => 'tarihce',
                'display_type' => 'standard',
                'content' => '<p>Mahallî İdareler Araştırma ve Geliştirme Merkezi (MİARGEM), 2005 yılında kurulmuştur.</p>
<p>Kuruluş döneminde Avrupa Birliği hibe programları ve bölgesel kalkınma projeleri konusunda belediyelerin desteklenmesi, proje ortaklıklarının geliştirilmesi ve Doğu Karadeniz Belediyeler Birliği ile müşterek çalışmalar yürütülmesi öncelikli alanlar arasında yer almıştır. TR90 bölgesindeki Artvin, Giresun, Gümüşhane, Ordu, Rize ve Trabzon illerinde yürütülen hibe projelerine destek sunulmuştur.</p>
<p>Bu çalışmalarla gelişen proje ve iş birliği deneyimi, zaman içinde ülke genelindeki belediyelerin ortak ihtiyaçlarını kapsayan bir faaliyet birikimine dönüşmüştür. “Türkiye’nin Mahallî İdareler Platformu” anlayışıyla farklı bölgelerdeki mahallî idarelerin bilgi ve deneyimlerinin buluşturulması, ortak sorunların değerlendirilmesi ve kurumlar arası öğrenmenin geliştirilmesi esas alınmıştır.</p>
<p>Belediyelere yönelik eğitim seminerleri, bölgesel ve ulusal düzeyde katılımla gerçekleştirilen eğitim toplantıları, paneller ve konferanslar bu birikimin önemli parçalarını oluşturmuştur. Seçilmiş görevliler, yöneticiler ve çalışanların akademisyenler ve uzmanlarla bir araya geldiği bu etkinliklerde; mevzuatın uygulamaya yansımaları, idarî ve malî sorunlar, kurumsal işleyiş ve meslekî gelişim ihtiyaçları ele alınmıştır. Farklı belediyelerin karşılaştıkları sorunların ve geliştirdikleri çözümlerin paylaşılması, çalışmaların uygulamayla bağını güçlendirmiştir.</p>
<p>Belediye Proje Günleri ve Etkin Belediye Proje Yarışması ile belediyelerin proje geliştirme birikiminin görünür kılınması ve kurumlar arasında paylaşılması amaçlanmıştır. Bu çalışmalar, yerel ihtiyaçlara çözüm üreten projelerin tanıtılmasına, uygulayıcıların deneyimlerini aktarmasına ve başka belediyelerde değerlendirilebilecek örneklerin ortaya konulmasına katkı sağlamıştır.</p>
<p>Araştırma, yayın, mevzuat bilgilendirmesi ve meslekî paylaşım çalışmaları da bu faaliyetleri tamamlamıştır. Mahallî idareler ile mahallî müşterek hizmet sunan kuruluşların uygulama soruları ve ortak ihtiyaçları, mevzuat araştırmalarının ve bilgi üretiminin gelişmesine kaynak oluşturmuştur.</p>
<p>Bugünkü yönelimimiz; araştırma, eğitim, yayın ve proje çalışmalarından edinilen bu birikimi, mahallî idarelerin ortak sorunlarını nedenleriyle açıklayan, gelecekteki ihtiyaçlarını öngören ve karar vericilere uygulanabilir seçenekler sunan sürekli bir araştırma kapasitesine dönüştürmektir.</p>',
                'items' => null,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Amacımız, Misyonumuz ve Vizyonumuz',
                'slug' => 'amac-misyon-vizyon',
                'display_type' => 'mission_vision',
                'content' => '<h3>3.1. Amacımız</h3>
<p>Mahallî idarelerin görev, yetki, kaynak ve kurumsal kapasitelerinin geliştirilmesine; mahallî müşterek ihtiyaçların etkili, verimli ve hukukî güvenlik içinde karşılanmasına araştırma ve politika çalışmalarıyla katkı sağlamak temel amacımızdır. Mahallî idarelerin ortak kurumsal hak ve menfaatlerini, kamu yararı ve vatandaşların nitelikli hizmetlere erişimi çerçevesinde ele alırız.</p>
<p>Yerel yönetim sisteminin yapısal sorunlarını; merkezî idare ile mahallî idareler arasındaki ilişkiler, görev ve kaynak paylaşımı, teşkilatlanma, insan kaynağı ve hizmet kapasitesi bakımından araştırırız. Kurumlara özgü incelemelerden elde edilen bilgiyi karşılaştırmalı analizlerle değerlendirerek ortak sorunların açıklanmasına ve farklı kurumlara uyarlanabilecek çözümler geliştirilmesine kaynak oluşturmayı amaçlarız.</p>
<p>Seçimle göreve gelen mahallî idare görevlileri ile atanmış yöneticilerin ve personelin statü, görev, yetki, sorumluluk, çalışma şartları ve meslekî gelişim ihtiyaçlarını sistem bütünlüğü içinde inceleriz. Araştırma sonuçlarının gerekçeli politika, mevzuat ve yönetim önerilerine dönüştürülmesini; kurumların stratejik kararlarına, hizmet kabiliyetlerine ve geleceğe hazırlıklarına katkı sağlamasını hedefleriz.</p>',
                'items' => [
                    [
                        'title' => '3.2. Misyonumuz',
                        'subtitle' => null,
                        'description' => '<p>Mahallî idarelerin ortak sorunlarını ve gelişim ihtiyaçlarını hukuk, veri ve saha bilgisiyle araştırmak; nedenlerini, yaygınlığını ve etkilerini ölçerek karşılaştırmak; politika seçenekleri, gerekçeli mevzuat önerileri, uyarlanabilir yönetim modelleri ve standartlar geliştirmek; önerileri ilgili karar mercilerine sunmak ve sonuçlarını izlemek.</p>
<p>Bu doğrultuda akademik bilgiyle uygulama deneyimini buluşturur; araştırma, yayın, meslekî gelişim ve ortak öğrenme çalışmalarıyla üretilen bilginin kullanılmasını destekleriz. Uluslararası deneyimleri ülkemizin hukukî, idarî ve malî yapısıyla birlikte değerlendirir; farklı kurum türleri ve ölçekleri için uygulanabilir çözümler geliştirmeyi esas alırız.</p>',
                    ],
                    [
                        'title' => '3.3. Vizyonumuz',
                        'subtitle' => null,
                        'description' => '<p>Türkiye’de mahallî idarelerin geleceğine ilişkin karar süreçlerinde güvenilir bilgisi, bilimsel yöntemi ve uygulanabilir önerileriyle başvurulan; politika, mevzuat ve kurumsal gelişim çalışmalarına yön veren bağımsız bir referans kuruluş olmak.</p>
<p>Mahallî idarelerin deneyimlerini ortak bilgiye dönüştüren, değişen ihtiyaçları öngören ve geliştirdiği önerilerin etkisini izleyerek kendisini yenileyen bir araştırma kapasitesiyle, yerel yönetimlerin güçlenmesine kalıcı katkı sağlamak.</p>',
                    ],
                    [
                        'title' => '3.4. Gelişim Önceliklerimiz',
                        'subtitle' => null,
                        'description' => null,
                    ],
                    [
                        'title' => null,
                        'subtitle' => 'a',
                        'description' => '<p>Yerel yönetim sisteminin yapısal sorunlarını; merkezî idare–mahallî idare ilişkileri, büyükşehir sistemi, görev ve yetki paylaşımı, kaynak yapısı ve kurumlar arası koordinasyon bakımından araştırmak.</p>',
                    ],
                    [
                        'title' => null,
                        'subtitle' => 'b',
                        'description' => '<p>Mahallî idarelerin ortak kurumsal hak ve menfaatlerini araştırma ve kanıtla ortaya koymak; görevlerini yerine getirebilmeleri için gerekli yetki, kaynak ve kapasitenin geliştirilmesine yönelik öneriler hazırlamak.</p>',
                    ],
                    [
                        'title' => null,
                        'subtitle' => 'c',
                        'description' => '<p>Kurumlara özgü araştırmalarla stratejik ve kurumsal gelişim ihtiyaçlarını belirlemek; bulguları karşılaştırmalı bilgiye ve farklı mahallî idarelere uyarlanabilecek modellere dönüştürmek.</p>',
                    ],
                    [
                        'title' => null,
                        'subtitle' => 'ç',
                        'description' => '<p>Yerel hizmet kabiliyetini; ihtiyaç belirleme, önceliklendirme, kaynak kullanımı, hizmete erişim ve süreklilik bakımından değerlendirmek; kurum türü, ölçeği ve yerel şartları gözeten gelişim çerçeveleri oluşturmak.</p>',
                    ],
                    [
                        'title' => null,
                        'subtitle' => 'd',
                        'description' => '<p>Seçilmiş görevliler ile atanmış yöneticilerin ve personelin statü ve çalışma şartlarına ilişkin ortak sorunları araştırmak; liyakati, meslekî yeterliliği, görev açıklığını ve kurumsal hafızayı güçlendirecek öneriler geliştirmek.</p>',
                    ],
                    [
                        'title' => null,
                        'subtitle' => 'e',
                        'description' => '<p>Mevzuat ve sistem değişikliklerinin mahallî idareler üzerindeki etkilerini önceden değerlendirmek; gerekçeli düzenleme metinleri, uygulama koşulları ve geçiş önerileri hazırlamak; düzenleme sonrasındaki sonuçları izlemek.</p>',
                    ],
                    [
                        'title' => null,
                        'subtitle' => 'f',
                        'description' => '<p>Stratejik yönetim, malî sürdürülebilirlik, iç kontrol ve denetim alanlarında önleyici yaklaşımları geliştirmek; tekrarlanan sorunların ortak nedenlerini açıklayan çalışmalar üretmek.</p>',
                    ],
                    [
                        'title' => null,
                        'subtitle' => 'g',
                        'description' => '<p>Araştırma sonuçlarının yayın, eğitim ve ortak öğrenme yoluyla paylaşılmasını; üniversiteler, mahallî idareler, uzmanlar ve uygulayıcılar arasında bilimsel iş birliğinin gelişmesini desteklemek.</p>',
                    ],
                    [
                        'title' => null,
                        'subtitle' => 'ğ',
                        'description' => '<p>Teknolojik gelişmeleri ve uluslararası uygulamaları kamu yararı, hukukî uygunluk, bilgi güvenliği ve kurumsal kapasite bakımından değerlendirmek; değişen toplumsal ihtiyaçlara ve geleceğin hizmet şartlarına hazırlığı desteklemek.</p>',
                    ],
                    [
                        'title' => null,
                        'subtitle' => 'h',
                        'description' => '<p>Kurumsal başarıyı, üretilen bilginin karar süreçlerinde kullanılması, önerilerin uygulanabilirliği ve hizmetlere katkısı üzerinden değerlendirmek; sonuçları izleyerek araştırma yöntemlerini ve modellerini geliştirmek.</p>',
                    ],
                ],
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Değerlerimiz ve Çalışma İlkelerimiz',
                'slug' => 'degerlerimiz',
                'display_type' => 'cards',
                'content' => null,
                'items' => [
                    [
                        'title' => '4.1. Kamu Yararı ve Hukukî Güvenlik',
                        'subtitle' => null,
                        'description' => '<p>Mahallî hizmetlerin niteliğini, kaynakların etkili kullanımını ve kararların açık hukukî dayanaklara sahip olmasını esas alırız. Hizmetlerde insan onurunun korunmasını ve farklı toplumsal grupların hizmetlere erişimini gözetiriz.</p>',
                    ],
                    [
                        'title' => '4.2. Bağımsızlık ve Tarafsızlık',
                        'subtitle' => null,
                        'description' => '<p>Farklı görüş ve yönetimlere aynı yöntem, kanıt standardı ve kurumsal mesafeyle yaklaşırız. Araştırma sonuçlarının siyasi, kurumsal veya malî beklentilere göre değiştirilmemesini temel ilke kabul ederiz.</p>',
                    ],
                    [
                        'title' => '4.3. Bilimsel Yöntem ve Kanıt',
                        'subtitle' => null,
                        'description' => '<p>Doğrulanmış olguları, yorumları, varsayımları ve önerileri birbirinden ayırırız. Kaynağı, yöntemi, veri dönemi ve sınırlılıkları açıklanabilen çalışmalar üretmeyi amaçlarız.</p>',
                    ],
                    [
                        'title' => '4.4. Uygulanabilirlik ve Ölçek Duyarlılığı',
                        'subtitle' => null,
                        'description' => '<p>Önerileri kurum türü, nüfus, coğrafya, personel, maliyet ve teknik kapasite bakımından değerlendirir; farklı şartlara uyarlanabilir çözümler geliştirmeyi hedefleriz.</p>',
                    ],
                    [
                        'title' => '4.5. Saydamlık ve Hesap Verebilirlik',
                        'subtitle' => null,
                        'description' => '<p>Araştırma, yayın ve destek ilişkilerinin açıklığını; kullanılan bilginin ve ulaşılan sonuçların izlenebilirliğini önemseriz.</p>',
                    ],
                    [
                        'title' => '4.6. Katılım ve Ortak Üretim',
                        'subtitle' => null,
                        'description' => '<p>Seçilmiş görevlilerin, yöneticilerin, çalışanların, akademisyenlerin ve uzmanların deneyimlerini buluştururuz. Vatandaşın ihtiyaç ve beklentilerini araştırmalarımızın temel bilgi kaynaklarından biri olarak görürüz.</p>',
                    ],
                    [
                        'title' => '4.7. Öğrenme ve Kurumsal Hafıza',
                        'subtitle' => null,
                        'description' => '<p>Yöntemlerin, deneyimlerin ve öğrenilen derslerin kaydedilmesini; bilginin kişiler, kurumlar ve dönemler arasında aktarılmasını kurumsal gelişimin şartı olarak değerlendiririz.</p>',
                    ],
                ],
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Stratejik Yönelimimiz',
                'slug' => 'stratejik-yonelim',
                'display_type' => 'standard',
                'content' => '<p>Mahallî idarelerin bugünkü sorunlarını çözebilmesi ve geleceğin hizmet ihtiyaçlarına hazırlanabilmesi, yerel yönetim sisteminin bütünü ile kurumların kendi şartlarının birlikte değerlendirilmesini gerektirir. Stratejik yönelimimiz; yapısal sorunları ortaya koyan, değişim ihtiyacını zamanında belirleyen ve karar vericilere uygulanabilir seçenekler sunan bir araştırma kapasitesi geliştirmektir. Merkezî idare ile mahallî idareler arasındaki görev, yetki ve kaynak paylaşımını; büyükşehir sistemini, gelir ve personel yapılarını, kurumlar arası ilişkileri ve ölçek farklılıklarını bu çerçevede ele alırız.</p>
<p>Araştırmalarımızda, kurumların kendi kararlarıyla giderebilecekleri işleyiş sorunları ile mevzuat ve sistem değişikliği gerektiren yapısal sorunları ayrıştırmayı esas alırız. Böylece çözüm önerilerinin doğru karar merciine yönelmesini, görevlerle kaynaklar arasında denge kurulmasını ve kurumların hizmet kabiliyetlerinin güçlendirilmesini amaçlarız. Düzenleme önerilerini, uygulama için gerekli kapasite, maliyet ve geçiş şartlarıyla birlikte değerlendiririz.</p>
<p>Kurumlara özgü araştırmaları, yerel deneyimden ortak bilgi üretmenin temel araçlarından biri olarak görürüz. Bir kurumda karşılaşılan sorunun başka idarelerde ne ölçüde tekrarlandığını, hangi şartlarda ortaya çıktığını ve hangi uygulamalarla giderilebildiğini araştırırız. Elde edilen bulguları karşılaştırmalı analizlere ve farklı kurumlara uyarlanabilir modellere dönüştürmeyi hedefleriz. Bu yaklaşımda stratejik planlama, teşkilatlanma, insan kaynağı ve malî yapı; hizmetin niteliğini ve sürekliliğini birlikte belirleyen unsurlardır.</p>
<p>Geleceğe hazırlığı, bugünden alınması gereken kararların konusu olarak ele alırız. Nüfus hareketleri, toplumsal ihtiyaçlar, afet ve iklim riskleri, malî yükümlülükler ve teknolojik gelişmelerin hizmetler üzerindeki etkilerini araştırmayı önceliklendiririz. Uluslararası deneyimleri ülkemizin hukukî, idarî ve malî şartlarıyla birlikte değerlendirir; yeniliklerin kamu yararına katkısını ve uygulanabilirliğini esas alırız.</p>
<p>Stratejik başarımızı, araştırmalarımızın karar süreçlerinde kullanılması ve kurumsal gelişime katkısı üzerinden değerlendirmeyi amaçlarız. Önerilerin uygulamadaki sonuçlarını izlemek, öngörülemeyen etkileri belirlemek ve öğrenilenleri yeni çalışmalara aktarmak, bu yönelimin devamıdır.</p>',
                'items' => null,
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'Kurumsal Yaklaşım ve Araştırma Yöntemi',
                'slug' => 'arastirma-yontemi',
                'display_type' => 'accordion',
                'content' => '<p>Mahallî idarelerin ortak sorunlarını ve gelişim ihtiyaçlarını hukuk, veri ve saha bilgisiyle araştırır; elde edilen bulguları uygulanabilir önerilere dönüştürmeyi ve sonuçlarını izlemeyi esas alırız. Yerel yönetim sistemini bütün olarak ele alan incelemelerle kurumlara özgü araştırmaların birbirini beslemesini önemseriz. Çalışmalarımız, sorunun belirlenmesinden uygulama sonuçlarının değerlendirilmesine uzanan altı aşamalı bir yaklaşım üzerine kuruludur.</p>',
                'items' => [
                    [
                        'title' => '6.1. Sorunun Belirlenmesi',
                        'subtitle' => null,
                        'description' => '<p>Mahallî idarelerin ve görevlilerinin karşılaştığı sorunlar; saha bildirimleri, kurumsal belgeler, resmî kaynaklar, bilimsel çalışmalar, yargı kararları ve denetim bulguları üzerinden değerlendirilir. Sorunun kimleri etkilediği, hangi şartlarda ortaya çıktığı, ne ölçüde tekrarlandığı ve hizmetler üzerinde nasıl sonuçlar doğurduğu belirlenir. Tek bir kurumdaki uygulamanın, sektörün tamamına ilişkin bir sorun olarak kabul edilmesinden önce karşılaştırmalı doğrulama yapılması gözetilir.</p>
<p>Yapısal sorunlarla kurum içi işleyiş sorunları; nedenleri, çözüm mercileri ve aralarındaki etkileşim bakımından ayrıştırılır. Mevzuat değişikliği gerektiren bir hususla mevcut yetkilerin daha etkili kullanılmasını gerektiren bir aksaklık aynı çerçevede ele alınmaz. Araştırmanın amacı, temel soruları ve kapsamı bu değerlendirmeye göre oluşturulur; önceliklerin belirlenmesinde sorunun yaygınlığı, kamu yararı, hizmet sürekliliği ve oluşturduğu riskler dikkate alınır.</p>',
                    ],
                    [
                        'title' => '6.2. Araştırma ve Analiz',
                        'subtitle' => null,
                        'description' => '<p>Belirlenen sorun, hukukî, idarî, malî ve beşerî boyutlarıyla incelenir. Mevzuatın öngördüğü işleyiş ile uygulamadaki durum karşılaştırılır; görev, yetki, kaynak, teşkilat ve insan kaynağı arasındaki ilişkiler değerlendirilir. Çalışmanın niteliğine göre belge incelemesi, görüşme, anket, saha gözlemi ve nicel analiz yöntemlerinden yararlanılır. Kurumsal kayıtlarla uygulayıcıların deneyimleri birlikte ele alınarak sorunun nedenleri ve sonuçları açıklanmaya çalışılır.</p>
<p>Farklı kurum türleri, büyüklükleri ve yerleşim özellikleri arasındaki karşılaştırmalarda nüfus, coğrafya, malî imkânlar ve teknik kapasite farklılıkları gözetilir. Uluslararası örnekler, ortaya çıktıkları hukukî ve kurumsal şartlarla birlikte değerlendirilir. Kaynaklar, veri dönemi, yöntem ve sınırlılıklar açıklanır; gözlenen bir ilişki ile kanıtlanabilen neden-sonuç bağı birbirinden ayrılır. Bulguların hangi kapsamda genellenebileceği açıkça belirtilir.</p>',
                    ],
                    [
                        'title' => '6.3. Çözüm Geliştirme',
                        'subtitle' => null,
                        'description' => '<p>Araştırma bulgularından hareketle politika, mevzuat ve sistem seçenekleri geliştirilir. Mevcut uygulamanın iyileştirilmesi, görev ve koordinasyon ilişkilerinin düzenlenmesi, kurumsal kapasitenin güçlendirilmesi veya mevzuat değişikliği yapılması gibi alternatifler karşılaştırılır. Her seçeneğin hangi sorunu, hangi mekanizmayla çözmesinin beklendiği açıklanır.</p>
<p>Seçenekler; kamu yararı, hukukî uygunluk, maliyet, personel ve teknik kapasite ihtiyacı, hizmete erişim ve uygulama süresi bakımından değerlendirilir. Farklı mahallî idare türleri ve ölçekleri üzerindeki etkiler ile mevcut hak ve yükümlülükler gözetilir. Uygulama riskleri, geçiş ihtiyaçları ve muhtemel istenmeyen sonuçlar belirlenir. Gerekli görülen durumlarda aşamalı uygulama veya pilot çalışma seçenekleri geliştirilir.</p>',
                    ],
                    [
                        'title' => '6.4. Önerinin Hazırlanması',
                        'subtitle' => null,
                        'description' => '<p>Değerlendirilen çözüm seçenekleri; araştırmanın niteliğine göre politika notuna, gerekçeli düzenleme metnine, yönetim modeline, standarda veya rehbere dönüştürülür. Öneri ile araştırma bulguları arasındaki bağ açıkça kurulur. Hangi seçeneğin neden tercih edildiği, beklenen faydaları ve bilinen sınırlılıklarıyla birlikte ortaya konulur.</p>
<p>Önerinin amacı, kapsamı ve uygulanacağı kurumlar belirlenir; görev ve sorumluluklar, kaynak ihtiyacı, uygulama adımları ve geçiş koşulları açıklanır. Mevzuat önerilerinde madde metniyle gerekçesinin uyumu gözetilir. Model ve standartlarda ise farklı kurum şartlarına göre uyarlanabilecek unsurlar gösterilir. Uygulama sonuçlarının değerlendirilebilmesi için izlenecek göstergeler ve ihtiyaç duyulacak bilgiler tanımlanır.</p>',
                    ],
                    [
                        'title' => '6.5. Karar Süreçlerine Katkı',
                        'subtitle' => null,
                        'description' => '<p>Taslaklar, konuyla ilgili uzmanların ve uygulayıcıların değerlendirmeleriyle geliştirilir. Çalışmanın kapsamına göre mahallî idarelerin, akademik çevrelerin ve ilgili diğer tarafların görüşlerinden yararlanılır. Görüş ayrılıkları, uygulama tereddütleri ve önerilen değişiklikler kaydedilir; taslağın hangi gerekçelerle güncellendiği izlenebilir hâle getirilir.</p>
<p>MİARGEM kurumsal görüşü olarak sunulacak çalışmalar, gerekli bilimsel, hukukî ve editoryal inceleme ile kurumsal onay sürecinin ardından ilgili karar mercilerine iletilir. Karar vericilerin ihtiyacına uygun özetler ve gerekçeli açıklamalarla önerinin değerlendirilmesi kolaylaştırılır. Yazar görüşleri, toplantı katılımcılarının değerlendirmeleri ve kurum adına benimsenen öneriler ayrı statülerde sunulur. Araştırma bulgularının ilgili taraflarca anlaşılması ve müzakere edilmesi, karar süreçlerine katkının bir parçası olarak görülür.</p>',
                    ],
                    [
                        'title' => '6.6. İzleme ve Öğrenme',
                        'subtitle' => null,
                        'description' => '<p>Önerilerin ilgili karar mercilerince nasıl değerlendirildiği, mevzuata veya kurumsal uygulamalara ne ölçüde yansıdığı ve hangi sonuçları doğurduğu izlenir. Bir önerinin kabul edilmesiyle uygulamada beklenen faydayı sağlaması ayrı değerlendirilir. İzleme çalışmalarında hizmetin niteliği, işlem süreleri, kaynak kullanımı, çalışanlar ve vatandaşlar üzerindeki sonuçlar, araştırmanın kapsamına uygun göstergeler üzerinden ele alınır.</p>
<p>Beklenen sonuçlarla gerçekleşmeler arasındaki farklılıklar ve öngörülmeyen etkiler araştırılır. Elde edilen bulgular, önerilerin ve yöntemlerin geliştirilmesinde kullanılır. Veri veya karşılaştırma imkânı yetersiz olduğunda değerlendirmenin sınırları açıkça belirtilir. Kaynakların, çalışma sürümlerinin, değerlendirme gerekçelerinin ve öğrenilen derslerin korunmasıyla kurumsal hafıza güçlendirilir; oluşan bilgi birikiminin sonraki araştırmalara aktarılması sağlanır.</p>',
                    ],
                ],
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'title' => 'Eğitim ve Meslekî Gelişim',
                'slug' => 'egitim',
                'display_type' => 'accordion',
                'content' => '<p>Meslekî gelişimi, araştırma sonuçlarının anlaşılmasını ve uygulamaya aktarılmasını destekleyen bir ortak öğrenme alanı olarak görürüz. Eğitim yaklaşımımızda kurumların gerçek ihtiyaçlarını, tekrarlanan uygulama sorunlarını, denetim bulgularını ve görevin gerektirdiği yetkinlikleri esas alırız. Seçilmiş görevliler, yöneticiler ve çalışanlar için içerik ve yöntemlerin farklılaştırılmasını; edinilen bilginin karar ve uygulama becerisine dönüşmesini önemseriz.</p>',
                'items' => [
                    [
                        'title' => '7.1. Eğitim Konu Alanları',
                        'subtitle' => null,
                        'description' => '<p>Eğitim çalışmalarımızın konu çerçevesini aşağıdaki kategoriler oluşturur. Her programın kapsamı, hedef kitlenin görevleri ve ihtiyaçları doğrultusunda belirlenir.</p>
<ul>
<li>a) <strong>Mahallî İdareler ve Karar Süreçleri:</strong> Mahallî idarelerin görev ve yetkileri, organların çalışma usulleri, meclis ve encümen işlemleri, kurumlar arası ilişkiler ve kararların uygulanması.</li>
<li>b) <strong>İnsan Kaynakları ve Personel Yönetimi:</strong> Personel statüleri, istihdam, norm kadro, görevde yükselme, özlük hakları, disiplin, iş ve sosyal güvenlik uygulamaları.</li>
<li>c) <strong>Malî Yönetim ve Belediye Gelirleri:</strong> Bütçe, muhasebe, gelirlerin tahakkuk ve tahsili, harcama süreçleri, borç ve yükümlülükler ile taşınır ve taşınmaz yönetimi.</li>
<li>ç) <strong>İhale ve Sözleşme Yönetimi:</strong> Mal ve hizmet alımları, yapım işleri, kiralama ve satış işlemleri, sözleşmelerin uygulanması, hakediş ve teminat süreçleri.</li>
<li>d) <strong>Stratejik Yönetim ve Kurumsal Kapasite:</strong> Stratejik planlama, performans yönetimi, teşkilatlanma, görev tanımları, süreç yönetimi, hizmet standartları ve kurumsal hafıza.</li>
<li>e) <strong>İç Kontrol, Risk ve Denetim:</strong> Ön malî kontrol, kurumsal riskler, denetim bulgularının değerlendirilmesi, kamu zararı, sorumluluk ve önleyici kontrol uygulamaları.</li>
<li>f) <strong>İmar, Taşınmaz ve Yerel Hizmetler:</strong> İmar ve ruhsat işlemleri, kamulaştırma, zabıta, çevre, altyapı ve diğer mahallî hizmetlerin hukukî ve yönetsel boyutları.</li>
<li>g) <strong>Belediye Şirketleri ve İştirakler:</strong> Belediye–şirket ilişkileri, yönetsel sorumluluklar, personel, satın alma, malî izleme ve hesap verebilirlik.</li>
<li>ğ) <strong>Araştırma, Veri ve Dijital Dönüşüm:</strong> Araştırma tasarımı, veri okuryazarlığı, etki değerlendirme, dijital hizmetler, yapay zekânın sorumlu kullanımı ve bilgi güvenliği.</li>
<li>h) <strong>Katılımcı Yönetim, İletişim ve Kurum Kültürü:</strong> Vatandaş katılımı, halkla ilişkiler, etik, liderlik, ekip çalışması, resmî yazışma, protokol ve kurum içi koordinasyon.</li>
<li>ı) <strong>Proje, Yerel Kalkınma ve Geleceğe Hazırlık:</strong> Proje geliştirme, fon kaynakları, kurumlar arası iş birliği, sosyal politika, afetlere hazırlık, iklim değişikliği ve hizmet sürekliliği.</li>
</ul>',
                    ],
                    [
                        'title' => '7.2. Eğitim Yöntemleri',
                        'subtitle' => null,
                        'description' => '<h3>7.2.1. Yüz Yüze Eğitimler</h3>
<p>Katılımcılarla doğrudan etkileşime dayanan seminer, uygulamalı eğitim ve atölye çalışmalarıdır. Kavramsal ve hukukî çerçeve; örnek olaylar, belge incelemeleri ve soru-cevap oturumlarıyla birlikte ele alınır. Farklı kurumların deneyimlerinin paylaşılması ve uygulama farklılıklarının değerlendirilmesi desteklenir.</p>
<h3>7.2.2. Odak Çalışmaları</h3>
<p>Belirli bir sorun, işlem veya görev alanına yoğunlaşan, sınırlı katılımcıyla yürütülen çalışmalardır. İlgili yönetici ve uygulayıcıların katılımıyla anonimleştirilmiş gerçek dosyalar, süreç örnekleri ve senaryolar değerlendirilir. Çalışmanın niteliğine göre kontrol listesi, süreç haritası, karar notu veya iyileştirme önerisi gibi somut öğrenme çıktıları geliştirilmesi amaçlanır.</p>
<h3>7.2.3. Çevrimiçi Eğitimler</h3>
<p>Farklı yerlerdeki katılımcıların bilgiye ve uzmanlığa erişimini kolaylaştıran uzaktan eğitim çalışmalarıdır. Canlı anlatım, soru-cevap, çevrimiçi vaka değerlendirmesi ve kısa çalışma oturumlarıyla yürütülür. Güncel gelişmelerin değerlendirilmesi ve belirli konularda süreklilik taşıyan öğrenme imkânlarının oluşturulması bakımından kullanılır.</p>',
                    ],
                    [
                        'title' => '7.3. Öğrenmenin Değerlendirilmesi',
                        'subtitle' => null,
                        'description' => '<p>Eğitimlerin değerlendirilmesinde katılımcının konuyu kavraması, görevine ilişkin riskleri tanıyabilmesi ve edindiği bilgiyi uygulamada kullanabilmesi esas alınır. Programın niteliğine göre vaka çözümü, kısa değerlendirme, hazırlanan çalışma çıktısı ve katılımcı geri bildirimlerinden yararlanılır. Konu, hedef kitle, yöntem, süre ve katılım koşulları ilgili eğitim ve etkinlik sayfalarında ayrıca açıklanır.</p>',
                    ],
                ],
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'title' => 'Bilimsel Toplantılar ve Ortak Öğrenme',
                'slug' => 'bilimsel-toplantilar',
                'display_type' => 'standard',
                'content' => '<p>Farklı disiplinlerden uzmanların, araştırmacıların ve uygulayıcıların ortak sorunları birlikte değerlendirmesini, bilgi üretiminin ve kurumsal öğrenmenin önemli bir parçası olarak görürüz. Akademik çalışmalarla saha deneyiminin buluşturulmasını; sorunların farklı yönlerinin anlaşılması, araştırma sorularının geliştirilmesi ve çözüm seçeneklerinin değerlendirilmesi bakımından önemseriz.</p>
<p>Bilimsel toplantıların amacı, kapsamı, katılımcı yapısı ve beklenen çıktıları önceden belirlenir. Görüşlerin güvenilir bilgiye dayanması, farklı yaklaşımların tartışılabilmesi ve uygulama güçlüklerinin açıkça ortaya konulması gözetilir. Ortaklaşılan hususlar kadar görüş ayrılıklarının ve cevaplanmayı bekleyen soruların da kaydedilmesi esas alınır.</p>
<p>Toplantılarda ortaya çıkan değerlendirmelerin araştırma gündemine, politika önerilerine ve meslekî öğrenmeye katkı sağlaması amaçlanır. Katılımcı görüşleri, toplantı sonuçları ve MİARGEM’in kurumsal görüşü ayrı statülerde ele alınır. Kurum adına benimsenecek öneriler gerekli değerlendirme ve onay sürecinden geçirilir.</p>',
                'items' => null,
                'sort_order' => 8,
                'is_active' => true,
            ],
            [
                'title' => 'Kurumsal Kapasite ve Yönetim Modelleri',
                'slug' => 'kurumsal-kapasite',
                'display_type' => 'standard',
                'content' => '<p>Kurumsal kapasiteyi, mahallî idarenin ihtiyaçları doğru belirleyebilmesi, önceliklerini kaynaklarıyla ilişkilendirebilmesi ve hizmetlerini süreklilik içinde yürütebilmesi bakımından değerlendiririz. Stratejik yönetim, teşkilatlanma, insan kaynağı, malî yapı, bilgi yönetimi ve kontrol mekanizmalarını birbirini etkileyen unsurlar olarak ele alırız.</p>
<p>Kurumların görevlerini yerine getirmesinde karşılaşılan güçlüklerin hangi nedenlerden kaynaklandığını araştırırız. Görev ve yetki belirsizlikleri, birimler arası koordinasyon eksiklikleri, kaynak yetersizlikleri ve kurumsal hafıza kayıplarının hizmet sonuçları üzerindeki etkilerini birlikte değerlendiririz. Belediye, bağlı kuruluş ve şirketler arasındaki ilişkileri de hizmetin bütünlüğü ve yönetsel sorumluluk bakımından inceleriz.</p>
<p>Model geliştirme yaklaşımımızda kurumların türü, ölçeği, coğrafi özellikleri ve hizmet şartları arasındaki farklılıklar gözetilir. Farklı mahallî idarelerin kendi ihtiyaçlarına uyarlayabileceği gelişim çerçeveleri oluşturulması hedeflenir. Önerilen modelin hangi şartlarda kullanılabileceği, hangi kaynakları gerektirdiği ve hangi alanlarda uyarlamaya ihtiyaç duyduğu açıklanır.</p>
<p>Belgelerin biçiminden çok yönetimi yönlendirme, görev açıklığını sağlama, riskleri azaltma ve hizmet sonuçlarını iyileştirme işlevini esas alırız. Geliştirilen modellerin uygulanabilirliğinin ve sonuçlarının değerlendirilmesini, model geliştirme sürecinin devamı olarak görürüz.</p>',
                'items' => null,
                'sort_order' => 9,
                'is_active' => true,
            ],
            [
                'title' => 'Kurumsal Sürdürülebilirlik ve Finansman İlkeleri',
                'slug' => 'surdurulebilirlik',
                'display_type' => 'standard',
                'content' => '<p>Kurumsal sürdürülebilirliği; araştırma kapasitesinin, uzmanlık birikiminin ve bilgi üretiminin sürekliliğinin korunması olarak ele alırız. Çalışma önceliklerinin mevcut insan kaynağı, zaman ve malî imkânlarla uyumlu belirlenmesini; üstlenilen çalışmaların tamamlanmasını ve elde edilen bilginin korunmasını önemseriz.</p>
<p>Araştırma ortaklıkları ve kurumsal amaçlarla uyumlu destek kaynaklarının geliştirilmesi bu yaklaşımın parçasıdır. Destek ilişkilerinde çalışmanın amacı, kapsamı, tarafların katkı ve sorumlulukları, finansman koşulları ile veri ve yayın hakları açıkça belirlenmelidir. Kaynakların kullanımının izlenebilir ve hesap verilebilir olması esas alınır.</p>
<p>Finansman ilişkileri, araştırmanın bağımsızlığını ve kurumsal önceliklerin kamu yararı temelinde belirlenmesini koruyacak biçimde yürütülmelidir. Destekçilerin yöntem, bulgu, değerlendirme, sonuç ve yayın kararlarını yönlendirmemesi temel ilkedir. Destek ilişkisinin doğurabileceği çıkar çatışmaları değerlendirilir ve gerekli açıklamalar yapılır.</p>
<p>Uzmanlık ve görevlerin belirli kişilerle sınırlı kalmaması, çalışma süreçlerinin kayıt altına alınması ve deneyimin aktarılması da sürdürülebilirliğin unsurlarıdır. Kurumun gelişimini, malî dayanıklılıkla birlikte araştırma niteliği, iş birliği kapasitesi ve kurumsal güvenilirlik bakımından değerlendiririz.</p>',
                'items' => null,
                'sort_order' => 10,
                'is_active' => true,
            ],
            [
                'title' => 'Yayın Politikası, Etik ve Bilgi Güvenliği',
                'slug' => 'yayin-politikasi',
                'display_type' => 'standard',
                'content' => '<p>Araştırma sonuçlarını anlaşılır, erişilebilir ve karar süreçlerinde kullanılabilir biçimde paylaşmayı amaçlarız. Yayınların kapsamı ve anlatımı, hedef kitlenin bilgi ihtiyacıyla uyumlu belirlenir. Bulguların dayanakları, kullanılan yöntem, veri dönemi ve sınırlılıklar açıkça gösterilir; kanıtın desteklediği sınırları aşan sonuç ve etki iddialarından kaçınılır.</p>
<p>Doğrulanmış bilgiler, yorumlar ve öneriler birbirinden ayrılır. Çalışma taslakları, imzalı yazar değerlendirmeleri ve MİARGEM kurumsal görüşleri farklı statülerde sunulur. Kurum adına yayımlanacak çalışmaların niteliğine uygun bilimsel, hukukî ve editoryal değerlendirme ile onay süreçlerinin tamamlanması esas alınır.</p>
<p>Araştırma ve yayınlarda kaynaklara doğru atıf yapılması, fikrî hakların korunması ve katkıların görünür kılınması gözetilir. Destek ilişkileri ve çıkar çatışmaları açıklanır. Maddi hataların düzeltilmesi, güncellemelerin tarihlendirilmesi ve sürüm değişikliklerinin izlenebilir olması kurumsal yayın sorumluluğunun parçasıdır.</p>
<p>Kişisel ve kurumsal bilgiler, çalışmanın amacı ve gerekli erişim sınırları içinde kullanılır. Gizlilik, veri güvenliği, saklama ihtiyacı ve anonimleştirme koşulları araştırmanın başlangıcından itibaren değerlendirilir. Kurumlara özgü çalışmalardan elde edilen bilgilerin ortak araştırmalarda kullanılması, kullanım yetkileri ve gizlilik yükümlülükleri gözetilerek ele alınır.</p>
<p>Özgün kaynakların, çalışma dosyalarının ve yayın sürümlerinin korunmasını kurumsal hafızanın parçası olarak görürüz. Bilginin güvenilir biçimde saklanmasını ve yetkili kişilerce erişilebilir olmasını, sonraki araştırmaların doğrulanabilirliği ve sürekliliği bakımından önemseriz.</p>',
                'items' => null,
                'sort_order' => 11,
                'is_active' => true,
            ],
            [
                'title' => 'MİARGEM Danışma Kurulu ve Kadrosu',
                'slug' => 'danisma-kurulu',
                'display_type' => 'team',
                'content' => '<p>MİARGEM’in çalışmaları; akademik araştırma, meslekî uzmanlık ve saha uygulaması alanlarında birikim sahibi çok sayıda akademisyen, uzman, yönetici ve uygulayıcının katkılarıyla gelişmektedir. Mahallî idarelerde fiilen görev yapanların deneyimleri ile farklı disiplinlerden araştırmacıların değerlendirmeleri, sorunların nedenlerinin anlaşılmasına ve uygulanabilir çözümler geliştirilmesine destek sağlamaktadır. Bu katkı çevresi, aşağıda yer verilen isimlerle sınırlı değildir.</p>
<p>Danışma Kurulu, bu geniş bilgi ve deneyim çevresinin katkılarını MİARGEM’in amaçları ve çalışma öncelikleriyle buluşturan yönlendirici, koordine edici ve destekleyici bir işlev üstlenir. Araştırma ihtiyaçlarının değerlendirilmesi, uygun uzmanlıkların bir araya getirilmesi ve çalışmaların kurumsal bütünlük içinde yürütülmesi için katkı sunar. İletişim, organizasyon, çalışma takibi ve lojistik destek süreçleriyle bilgi üretiminin sürekliliğini kolaylaştırır.</p>
<p>Çalışmaların bilimsel ve meslekî içeriği, ele alınan konunun gerektirdiği uzmanlıklar ve uygulama deneyimleriyle geliştirilir. Akademisyenlerin, meslek mensuplarının ve sahada çalışan yetkin kişilerin araştırma, değerlendirme, yayın ve ortak öğrenme süreçlerine katkıları önemsenir. Danışma Kurulu ve kadronun yönlendirici ve lojistik katkısı, bu birikimin ortak amaçlar doğrultusunda değerlendirilmesine hizmet eder.</p>
<p>Kurumsal görevler, Danışma Kurulu üyeliği ve çalışmalara sunulan uzmanlık katkıları birbirinden ayrılarak ele alınır. Katkı sunan kişilerin değerlendirmeleri ile MİARGEM adına açıklanan kurumsal görüşler ayrı statülerde sunulur. Kurumsal görüşler, gerekli inceleme ve onay sürecinin ardından yayımlanır.</p>',
                'items' => [
                    [
                        'title' => 'Halil MEMİŞ',
                        'subtitle' => 'MİARGEM Başkanı ve Danışma Kurulu Başkanı',
                        'description' => null,
                    ],
                    [
                        'title' => 'Salih ÜÇÜNCÜ',
                        'subtitle' => 'MİARGEM Başkan Yardımcısı ve Mevzuat',
                        'description' => null,
                    ],
                    [
                        'title' => 'Dr. Can Emre MEMİŞ',
                        'subtitle' => 'Araştırma ve Etki Analizi',
                        'description' => null,
                    ],
                    [
                        'title' => 'Dr. Niyazi KARABULUT',
                        'subtitle' => 'Araştırma',
                        'description' => null,
                    ],
                    [
                        'title' => 'Süleyman BAYINDIR',
                        'subtitle' => 'Malî Analiz',
                        'description' => null,
                    ],
                    [
                        'title' => 'Av. Haluk ERTEK',
                        'subtitle' => 'Hukuk',
                        'description' => null,
                    ],
                    [
                        'title' => 'Cansu KARAKILIÇ',
                        'subtitle' => 'Kurumsal İletişim',
                        'description' => null,
                    ],
                ],
                'sort_order' => 12,
                'is_active' => true,
            ],
            [
                'title' => 'İş Birliği İlkelerimiz',
                'slug' => 'is-birligi',
                'display_type' => 'standard',
                'content' => '<p>Mahallî idareler, birlikler, üniversiteler, meslek kuruluşları, araştırmacılar ve uygulayıcılarla bilgi paylaşımını ve ortak üretimi önemseriz. İş birliklerinin, tanımlanmış bir araştırma ihtiyacına veya kurumsal amaca dayanmasını; tarafların bilgi ve deneyimlerinin birbirini tamamlamasını esas alırız.</p>
<p>Ortak çalışmaların amacı, kapsamı, beklenen çıktıları, katkı ve sorumlulukları ile değerlendirme biçimi başlangıçta açıklığa kavuşturulmalıdır. Verilerin kullanım koşulları, gizlilik yükümlülükleri, fikrî haklar ve yayın esasları taraflar arasında belirlenmelidir. Kurumsal adların ve katkıların nasıl gösterileceği de bu çerçevede ele alınmalıdır.</p>
<p>Farklı görüş ve uzmanlıkların katkısı, bağımsızlık ve bilimsel yöntem ilkeleri doğrultusunda değerlendirilir. İş birliği ilişkisinin araştırmanın sonuçlarını önceden belirlememesi ve değerlendirme serbestisini sınırlamaması esastır. Uluslararası ortaklıklarda da ülkemizin hukukî ve idarî şartları ile mahallî idarelerin ihtiyaçları gözetilir.</p>
<p>Ortak çalışmaların sonuçlarının paylaşılmasını, edinilen deneyimin kaydedilmesini ve sonraki çalışmalarda kullanılmasını destekleriz. İş birliğinin değerini, ortak bilgi üretimine ve mahallî idarelerin gelişimine sağladığı katkı üzerinden değerlendiririz.</p>',
                'items' => null,
                'sort_order' => 13,
                'is_active' => true,
            ],
            [
                'title' => 'Kurumsal Belgeler ve Faaliyet Raporları',
                'slug' => 'kurumsal-belgeler',
                'display_type' => 'standard',
                'content' => '<p>Kurumsal çalışma esaslarının, araştırma ve yayın ilkelerinin ve dönemsel faaliyetlerin izlenebilir belgelerle açıklanmasını hedefleriz. Bu belgelerin, MİARGEM’in amaçlarıyla yürüttüğü çalışmalar arasındaki ilişkinin anlaşılmasını ve kurumsal gelişimin değerlendirilmesini sağlamasını önemseriz.</p>
<p>Onaylanan ve erişime açılan belgeler; adları, dönemleri, tarihleri ve sürüm bilgileriyle sunulur. Güncellenen belgelerde önceki sürümle ilişkinin ve değişikliklerin takip edilebilir olması gözetilir. Hazırlık aşamasındaki çalışmalar ile yürürlükteki veya yayımlanmış belgeler açıkça ayrılır.</p>
<p>Faaliyet raporlarında gerçekleştirilen çalışmalar, üretilen çıktılar, kurulan iş birlikleri ve kullanılan kaynaklara ilişkin bilgiler, raporun kapsamına uygun biçimde değerlendirilir. Planlanan faaliyetlerle gerçekleşmeler arasındaki farklılıklar ve bunların nedenleri açıklanır. Tamamlanamayan çalışmalar ve karşılaşılan güçlükler de kurumsal öğrenmenin parçası olarak ele alınır.</p>
<p>Faaliyetlerin değerlendirilmesinde üretilen bilginin karar süreçlerinde kullanılması, önerilerin uygulamadaki karşılığı ve elde edilen sonuçlar gözetilir. Sonuç ve etki değerlendirmeleri mevcut kanıtın desteklediği ölçüde yapılır. Öğrenilen derslerin sonraki çalışma önceliklerine aktarılmasıyla raporlamanın kurumsal gelişime hizmet etmesi amaçlanır.</p>',
                'items' => null,
                'sort_order' => 14,
                'is_active' => true,
            ],
        ];
    }
}
