
```
grok
├─ composer.json
├─ composer.lock
├─ contenedores_db (6).sql
├─ css
│  ├─ index.css
│  ├─ registro.css
│  ├─ servicio.css
│  ├─ servicios1.css
│  └─ turno.css
├─ html
│  └─ registro.html
├─ js
├─ php
│  ├─ admin
│  │  ├─ barba_admin.php
│  │  ├─ corte_admin.php
│  │  ├─ lavado_admin.php
│  │  ├─ peinado_admin.php
│  │  ├─ tintura_admin.php
│  │  └─ turnos_admin.php
│  ├─ cancelar_turno.php
│  ├─ conexion.php
│  ├─ config_admin.php
│  ├─ descargar_comprobante.php
│  ├─ dompdf
│  │  ├─ AUTHORS.md
│  │  ├─ autoload.inc.php
│  │  ├─ LICENSE.LGPL
│  │  ├─ README.md
│  │  ├─ vendor
│  │  │  ├─ autoload.php
│  │  │  ├─ composer
│  │  │  │  ├─ autoload_classmap.php
│  │  │  │  ├─ autoload_namespaces.php
│  │  │  │  ├─ autoload_psr4.php
│  │  │  │  ├─ autoload_real.php
│  │  │  │  ├─ autoload_static.php
│  │  │  │  ├─ ClassLoader.php
│  │  │  │  ├─ installed.json
│  │  │  │  ├─ installed.php
│  │  │  │  ├─ InstalledVersions.php
│  │  │  │  ├─ LICENSE
│  │  │  │  └─ platform_check.php
│  │  │  ├─ dompdf
│  │  │  │  ├─ dompdf
│  │  │  │  │  ├─ AUTHORS.md
│  │  │  │  │  ├─ composer.json
│  │  │  │  │  ├─ lib
│  │  │  │  │  │  ├─ Cpdf.php
│  │  │  │  │  │  ├─ fonts
│  │  │  │  │  │  │  ├─ Courier-Bold.afm
│  │  │  │  │  │  │  ├─ Courier-BoldOblique.afm
│  │  │  │  │  │  │  ├─ Courier-Oblique.afm
│  │  │  │  │  │  │  ├─ Courier.afm
│  │  │  │  │  │  │  ├─ DejaVuSans-Bold.ttf
│  │  │  │  │  │  │  ├─ DejaVuSans-Bold.ufm
│  │  │  │  │  │  │  ├─ DejaVuSans-BoldOblique.ttf
│  │  │  │  │  │  │  ├─ DejaVuSans-BoldOblique.ufm
│  │  │  │  │  │  │  ├─ DejaVuSans-Oblique.ttf
│  │  │  │  │  │  │  ├─ DejaVuSans-Oblique.ufm
│  │  │  │  │  │  │  ├─ DejaVuSans.ttf
│  │  │  │  │  │  │  ├─ DejaVuSans.ufm
│  │  │  │  │  │  │  ├─ DejaVuSansMono-Bold.ttf
│  │  │  │  │  │  │  ├─ DejaVuSansMono-Bold.ufm
│  │  │  │  │  │  │  ├─ DejaVuSansMono-BoldOblique.ttf
│  │  │  │  │  │  │  ├─ DejaVuSansMono-BoldOblique.ufm
│  │  │  │  │  │  │  ├─ DejaVuSansMono-Oblique.ttf
│  │  │  │  │  │  │  ├─ DejaVuSansMono-Oblique.ufm
│  │  │  │  │  │  │  ├─ DejaVuSansMono.ttf
│  │  │  │  │  │  │  ├─ DejaVuSansMono.ufm
│  │  │  │  │  │  │  ├─ DejaVuSerif-Bold.ttf
│  │  │  │  │  │  │  ├─ DejaVuSerif-Bold.ufm
│  │  │  │  │  │  │  ├─ DejaVuSerif-BoldItalic.ttf
│  │  │  │  │  │  │  ├─ DejaVuSerif-BoldItalic.ufm
│  │  │  │  │  │  │  ├─ DejaVuSerif-Italic.ttf
│  │  │  │  │  │  │  ├─ DejaVuSerif-Italic.ufm
│  │  │  │  │  │  │  ├─ DejaVuSerif.ttf
│  │  │  │  │  │  │  ├─ DejaVuSerif.ufm
│  │  │  │  │  │  │  ├─ Helvetica-Bold.afm
│  │  │  │  │  │  │  ├─ Helvetica-Bold.afm.json
│  │  │  │  │  │  │  ├─ Helvetica-BoldOblique.afm
│  │  │  │  │  │  │  ├─ Helvetica-BoldOblique.afm.json
│  │  │  │  │  │  │  ├─ Helvetica-Oblique.afm
│  │  │  │  │  │  │  ├─ Helvetica-Oblique.afm.json
│  │  │  │  │  │  │  ├─ Helvetica.afm
│  │  │  │  │  │  │  ├─ Helvetica.afm.json
│  │  │  │  │  │  │  ├─ installed-fonts.dist.json
│  │  │  │  │  │  │  ├─ mustRead.html
│  │  │  │  │  │  │  ├─ Symbol.afm
│  │  │  │  │  │  │  ├─ Times-Bold.afm
│  │  │  │  │  │  │  ├─ Times-BoldItalic.afm
│  │  │  │  │  │  │  ├─ Times-Italic.afm
│  │  │  │  │  │  │  ├─ Times-Roman.afm
│  │  │  │  │  │  │  └─ ZapfDingbats.afm
│  │  │  │  │  │  └─ res
│  │  │  │  │  │     ├─ broken_image.png
│  │  │  │  │  │     ├─ broken_image.svg
│  │  │  │  │  │     ├─ html.css
│  │  │  │  │  │     ├─ sRGB2014.icc
│  │  │  │  │  │     └─ sRGB2014.icc.LICENSE
│  │  │  │  │  ├─ LICENSE.LGPL
│  │  │  │  │  ├─ phpunit.xml
│  │  │  │  │  ├─ README.md
│  │  │  │  │  ├─ src
│  │  │  │  │  │  ├─ Adapter
│  │  │  │  │  │  │  ├─ CPDF.php
│  │  │  │  │  │  │  ├─ GD.php
│  │  │  │  │  │  │  └─ PDFLib.php
│  │  │  │  │  │  ├─ Canvas.php
│  │  │  │  │  │  ├─ CanvasFactory.php
│  │  │  │  │  │  ├─ Cellmap.php
│  │  │  │  │  │  ├─ Css
│  │  │  │  │  │  │  ├─ AttributeTranslator.php
│  │  │  │  │  │  │  ├─ Color.php
│  │  │  │  │  │  │  ├─ Content
│  │  │  │  │  │  │  │  ├─ Attr.php
│  │  │  │  │  │  │  │  ├─ CloseQuote.php
│  │  │  │  │  │  │  │  ├─ ContentPart.php
│  │  │  │  │  │  │  │  ├─ Counter.php
│  │  │  │  │  │  │  │  ├─ Counters.php
│  │  │  │  │  │  │  │  ├─ NoCloseQuote.php
│  │  │  │  │  │  │  │  ├─ NoOpenQuote.php
│  │  │  │  │  │  │  │  ├─ OpenQuote.php
│  │  │  │  │  │  │  │  ├─ StringPart.php
│  │  │  │  │  │  │  │  └─ Url.php
│  │  │  │  │  │  │  ├─ Style.php
│  │  │  │  │  │  │  └─ Stylesheet.php
│  │  │  │  │  │  ├─ Dompdf.php
│  │  │  │  │  │  ├─ Exception
│  │  │  │  │  │  │  └─ ImageException.php
│  │  │  │  │  │  ├─ Exception.php
│  │  │  │  │  │  ├─ FontMetrics.php
│  │  │  │  │  │  ├─ Frame
│  │  │  │  │  │  │  ├─ Factory.php
│  │  │  │  │  │  │  ├─ FrameListIterator.php
│  │  │  │  │  │  │  ├─ FrameTree.php
│  │  │  │  │  │  │  └─ FrameTreeIterator.php
│  │  │  │  │  │  ├─ Frame.php
│  │  │  │  │  │  ├─ FrameDecorator
│  │  │  │  │  │  │  ├─ AbstractFrameDecorator.php
│  │  │  │  │  │  │  ├─ Block.php
│  │  │  │  │  │  │  ├─ Image.php
│  │  │  │  │  │  │  ├─ Inline.php
│  │  │  │  │  │  │  ├─ ListBullet.php
│  │  │  │  │  │  │  ├─ ListBulletImage.php
│  │  │  │  │  │  │  ├─ NullFrameDecorator.php
│  │  │  │  │  │  │  ├─ Page.php
│  │  │  │  │  │  │  ├─ Table.php
│  │  │  │  │  │  │  ├─ TableCell.php
│  │  │  │  │  │  │  ├─ TableRow.php
│  │  │  │  │  │  │  ├─ TableRowGroup.php
│  │  │  │  │  │  │  └─ Text.php
│  │  │  │  │  │  ├─ FrameReflower
│  │  │  │  │  │  │  ├─ AbstractFrameReflower.php
│  │  │  │  │  │  │  ├─ Block.php
│  │  │  │  │  │  │  ├─ Image.php
│  │  │  │  │  │  │  ├─ Inline.php
│  │  │  │  │  │  │  ├─ ListBullet.php
│  │  │  │  │  │  │  ├─ NullFrameReflower.php
│  │  │  │  │  │  │  ├─ Page.php
│  │  │  │  │  │  │  ├─ Table.php
│  │  │  │  │  │  │  ├─ TableCell.php
│  │  │  │  │  │  │  ├─ TableRow.php
│  │  │  │  │  │  │  ├─ TableRowGroup.php
│  │  │  │  │  │  │  └─ Text.php
│  │  │  │  │  │  ├─ Helpers.php
│  │  │  │  │  │  ├─ Image
│  │  │  │  │  │  │  └─ Cache.php
│  │  │  │  │  │  ├─ JavascriptEmbedder.php
│  │  │  │  │  │  ├─ LineBox.php
│  │  │  │  │  │  ├─ Options.php
│  │  │  │  │  │  ├─ PhpEvaluator.php
│  │  │  │  │  │  ├─ Positioner
│  │  │  │  │  │  │  ├─ Absolute.php
│  │  │  │  │  │  │  ├─ AbstractPositioner.php
│  │  │  │  │  │  │  ├─ Block.php
│  │  │  │  │  │  │  ├─ Fixed.php
│  │  │  │  │  │  │  ├─ Inline.php
│  │  │  │  │  │  │  ├─ ListBullet.php
│  │  │  │  │  │  │  ├─ NullPositioner.php
│  │  │  │  │  │  │  ├─ TableCell.php
│  │  │  │  │  │  │  └─ TableRow.php
│  │  │  │  │  │  ├─ Renderer
│  │  │  │  │  │  │  ├─ AbstractRenderer.php
│  │  │  │  │  │  │  ├─ Block.php
│  │  │  │  │  │  │  ├─ Image.php
│  │  │  │  │  │  │  ├─ Inline.php
│  │  │  │  │  │  │  ├─ ListBullet.php
│  │  │  │  │  │  │  ├─ TableCell.php
│  │  │  │  │  │  │  ├─ TableRow.php
│  │  │  │  │  │  │  ├─ TableRowGroup.php
│  │  │  │  │  │  │  └─ Text.php
│  │  │  │  │  │  └─ Renderer.php
│  │  │  │  │  └─ VERSION
│  │  │  │  ├─ php-font-lib
│  │  │  │  │  ├─ AUTHORS.md
│  │  │  │  │  ├─ composer.json
│  │  │  │  │  ├─ LICENSE
│  │  │  │  │  ├─ maps
│  │  │  │  │  │  ├─ adobe-standard-encoding.map
│  │  │  │  │  │  ├─ cp1250.map
│  │  │  │  │  │  ├─ cp1251.map
│  │  │  │  │  │  ├─ cp1252.map
│  │  │  │  │  │  ├─ cp1253.map
│  │  │  │  │  │  ├─ cp1254.map
│  │  │  │  │  │  ├─ cp1255.map
│  │  │  │  │  │  ├─ cp1257.map
│  │  │  │  │  │  ├─ cp1258.map
│  │  │  │  │  │  ├─ cp874.map
│  │  │  │  │  │  ├─ iso-8859-1.map
│  │  │  │  │  │  ├─ iso-8859-11.map
│  │  │  │  │  │  ├─ iso-8859-15.map
│  │  │  │  │  │  ├─ iso-8859-16.map
│  │  │  │  │  │  ├─ iso-8859-2.map
│  │  │  │  │  │  ├─ iso-8859-4.map
│  │  │  │  │  │  ├─ iso-8859-5.map
│  │  │  │  │  │  ├─ iso-8859-7.map
│  │  │  │  │  │  ├─ iso-8859-9.map
│  │  │  │  │  │  ├─ koi8-r.map
│  │  │  │  │  │  └─ koi8-u.map
│  │  │  │  │  ├─ README.md
│  │  │  │  │  └─ src
│  │  │  │  │     └─ FontLib
│  │  │  │  │        ├─ AdobeFontMetrics.php
│  │  │  │  │        ├─ BinaryStream.php
│  │  │  │  │        ├─ EncodingMap.php
│  │  │  │  │        ├─ EOT
│  │  │  │  │        │  ├─ File.php
│  │  │  │  │        │  └─ Header.php
│  │  │  │  │        ├─ Exception
│  │  │  │  │        │  └─ FontNotFoundException.php
│  │  │  │  │        ├─ Font.php
│  │  │  │  │        ├─ Glyph
│  │  │  │  │        │  ├─ Outline.php
│  │  │  │  │        │  ├─ OutlineComponent.php
│  │  │  │  │        │  ├─ OutlineComposite.php
│  │  │  │  │        │  └─ OutlineSimple.php
│  │  │  │  │        ├─ Header.php
│  │  │  │  │        ├─ OpenType
│  │  │  │  │        │  ├─ File.php
│  │  │  │  │        │  └─ TableDirectoryEntry.php
│  │  │  │  │        ├─ Table
│  │  │  │  │        │  ├─ DirectoryEntry.php
│  │  │  │  │        │  ├─ Table.php
│  │  │  │  │        │  └─ Type
│  │  │  │  │        │     ├─ cmap.php
│  │  │  │  │        │     ├─ cvt.php
│  │  │  │  │        │     ├─ fpgm.php
│  │  │  │  │        │     ├─ glyf.php
│  │  │  │  │        │     ├─ head.php
│  │  │  │  │        │     ├─ hhea.php
│  │  │  │  │        │     ├─ hmtx.php
│  │  │  │  │        │     ├─ kern.php
│  │  │  │  │        │     ├─ loca.php
│  │  │  │  │        │     ├─ maxp.php
│  │  │  │  │        │     ├─ name.php
│  │  │  │  │        │     ├─ nameRecord.php
│  │  │  │  │        │     ├─ os2.php
│  │  │  │  │        │     ├─ post.php
│  │  │  │  │        │     └─ prep.php
│  │  │  │  │        ├─ TrueType
│  │  │  │  │        │  ├─ Collection.php
│  │  │  │  │        │  ├─ File.php
│  │  │  │  │        │  ├─ Header.php
│  │  │  │  │        │  └─ TableDirectoryEntry.php
│  │  │  │  │        └─ WOFF
│  │  │  │  │           ├─ File.php
│  │  │  │  │           ├─ Header.php
│  │  │  │  │           └─ TableDirectoryEntry.php
│  │  │  │  └─ php-svg-lib
│  │  │  │     ├─ AUTHORS.md
│  │  │  │     ├─ composer.json
│  │  │  │     ├─ LICENSE
│  │  │  │     ├─ README.md
│  │  │  │     └─ src
│  │  │  │        └─ Svg
│  │  │  │           ├─ CssLength.php
│  │  │  │           ├─ DefaultStyle.php
│  │  │  │           ├─ Document.php
│  │  │  │           ├─ Gradient
│  │  │  │           │  └─ Stop.php
│  │  │  │           ├─ Style.php
│  │  │  │           ├─ Surface
│  │  │  │           │  ├─ CPdf.php
│  │  │  │           │  ├─ SurfaceCpdf.php
│  │  │  │           │  ├─ SurfaceInterface.php
│  │  │  │           │  └─ SurfacePDFLib.php
│  │  │  │           └─ Tag
│  │  │  │              ├─ AbstractTag.php
│  │  │  │              ├─ Anchor.php
│  │  │  │              ├─ Circle.php
│  │  │  │              ├─ ClipPath.php
│  │  │  │              ├─ Ellipse.php
│  │  │  │              ├─ Group.php
│  │  │  │              ├─ Image.php
│  │  │  │              ├─ Line.php
│  │  │  │              ├─ LinearGradient.php
│  │  │  │              ├─ Path.php
│  │  │  │              ├─ Polygon.php
│  │  │  │              ├─ Polyline.php
│  │  │  │              ├─ RadialGradient.php
│  │  │  │              ├─ Rect.php
│  │  │  │              ├─ Shape.php
│  │  │  │              ├─ Stop.php
│  │  │  │              ├─ StyleTag.php
│  │  │  │              ├─ Symbol.php
│  │  │  │              ├─ Text.php
│  │  │  │              └─ UseTag.php
│  │  │  ├─ masterminds
│  │  │  │  └─ html5
│  │  │  │     ├─ bin
│  │  │  │     │  └─ entities.php
│  │  │  │     ├─ composer.json
│  │  │  │     ├─ CREDITS
│  │  │  │     ├─ LICENSE.txt
│  │  │  │     ├─ README.md
│  │  │  │     ├─ RELEASE.md
│  │  │  │     ├─ src
│  │  │  │     │  ├─ HTML5
│  │  │  │     │  │  ├─ Elements.php
│  │  │  │     │  │  ├─ Entities.php
│  │  │  │     │  │  ├─ Exception.php
│  │  │  │     │  │  ├─ InstructionProcessor.php
│  │  │  │     │  │  ├─ Parser
│  │  │  │     │  │  │  ├─ CharacterReference.php
│  │  │  │     │  │  │  ├─ DOMTreeBuilder.php
│  │  │  │     │  │  │  ├─ EventHandler.php
│  │  │  │     │  │  │  ├─ FileInputStream.php
│  │  │  │     │  │  │  ├─ InputStream.php
│  │  │  │     │  │  │  ├─ ParseError.php
│  │  │  │     │  │  │  ├─ README.md
│  │  │  │     │  │  │  ├─ Scanner.php
│  │  │  │     │  │  │  ├─ StringInputStream.php
│  │  │  │     │  │  │  ├─ Tokenizer.php
│  │  │  │     │  │  │  ├─ TreeBuildingRules.php
│  │  │  │     │  │  │  └─ UTF8Utils.php
│  │  │  │     │  │  └─ Serializer
│  │  │  │     │  │     ├─ HTML5Entities.php
│  │  │  │     │  │     ├─ OutputRules.php
│  │  │  │     │  │     ├─ README.md
│  │  │  │     │  │     ├─ RulesInterface.php
│  │  │  │     │  │     └─ Traverser.php
│  │  │  │     │  └─ HTML5.php
│  │  │  │     └─ UPGRADING.md
│  │  │  └─ sabberworm
│  │  │     └─ php-css-parser
│  │  │        ├─ CHANGELOG.md
│  │  │        ├─ composer.json
│  │  │        ├─ LICENSE
│  │  │        ├─ README.md
│  │  │        └─ src
│  │  │           ├─ Comment
│  │  │           │  ├─ Comment.php
│  │  │           │  └─ Commentable.php
│  │  │           ├─ CSSElement.php
│  │  │           ├─ CSSList
│  │  │           │  ├─ AtRuleBlockList.php
│  │  │           │  ├─ CSSBlockList.php
│  │  │           │  ├─ CSSList.php
│  │  │           │  ├─ Document.php
│  │  │           │  └─ KeyFrame.php
│  │  │           ├─ OutputFormat.php
│  │  │           ├─ OutputFormatter.php
│  │  │           ├─ Parser.php
│  │  │           ├─ Parsing
│  │  │           │  ├─ Anchor.php
│  │  │           │  ├─ OutputException.php
│  │  │           │  ├─ ParserState.php
│  │  │           │  ├─ SourceException.php
│  │  │           │  ├─ UnexpectedEOFException.php
│  │  │           │  └─ UnexpectedTokenException.php
│  │  │           ├─ Position
│  │  │           │  ├─ Position.php
│  │  │           │  └─ Positionable.php
│  │  │           ├─ Property
│  │  │           │  ├─ AtRule.php
│  │  │           │  ├─ Charset.php
│  │  │           │  ├─ CSSNamespace.php
│  │  │           │  ├─ Import.php
│  │  │           │  ├─ KeyframeSelector.php
│  │  │           │  └─ Selector.php
│  │  │           ├─ Renderable.php
│  │  │           ├─ Rule
│  │  │           │  └─ Rule.php
│  │  │           ├─ RuleSet
│  │  │           │  ├─ AtRuleSet.php
│  │  │           │  ├─ DeclarationBlock.php
│  │  │           │  └─ RuleSet.php
│  │  │           ├─ Settings.php
│  │  │           └─ Value
│  │  │              ├─ CalcFunction.php
│  │  │              ├─ CalcRuleValueList.php
│  │  │              ├─ Color.php
│  │  │              ├─ CSSFunction.php
│  │  │              ├─ CSSString.php
│  │  │              ├─ LineName.php
│  │  │              ├─ PrimitiveValue.php
│  │  │              ├─ RuleValueList.php
│  │  │              ├─ Size.php
│  │  │              ├─ URL.php
│  │  │              ├─ Value.php
│  │  │              └─ ValueList.php
│  │  └─ VERSION
│  ├─ fetch_config_por_dia.php
│  ├─ fetch_historial_turnos.php
│  ├─ fetch_horarios_disponibles.php
│  ├─ fetch_subservicios.php
│  ├─ fetch_turnos_ocupados.php
│  ├─ fetch_turnos_por_dia.php
│  ├─ generate_horarios.php
│  ├─ guardar_barba.php
│  ├─ guardar_corte.php
│  ├─ guardar_foto.php
│  ├─ guardar_intro.php
│  ├─ guardar_lavado.php
│  ├─ guardar_peinado.php
│  ├─ guardar_portada.php
│  ├─ guardar_servicio.php
│  ├─ guardar_tintura.php
│  ├─ guardar_turno.php
│  ├─ index_admin.php
│  ├─ index_cliente.php
│  ├─ index_principal.php
│  ├─ mis_turnos.php
│  ├─ procesar_login.php
│  ├─ procesar_recuperacion.php
│  ├─ procesar_registro.php
│  ├─ reset_password.php
│  ├─ servicios
│  │  ├─ barba.php
│  │  ├─ barba_publico.php
│  │  ├─ corte.php
│  │  ├─ corte_publico.php
│  │  ├─ lavado.php
│  │  ├─ lavado_publico.php
│  │  ├─ peinado.php
│  │  ├─ peinado_publico.php
│  │  ├─ tintura.php
│  │  └─ tintura_publico.php
│  ├─ turno.php
│  ├─ turnos_admin.php
│  └─ uploads
│     ├─ 68e40e9945e1f_index img.jpg
│     ├─ 68ec452974f25_illustration-anime-character-rain.jpg
│     ├─ 68ec45d473cf8_illustration-anime-character-rain.jpg
│     ├─ 68ec47e0a5554_illustration-anime-character-rain.jpg
│     ├─ 68ec48c6af93a_illustration-anime-character-rain.jpg
│     ├─ 68ec4ac57764e_illustration-anime-character-rain.jpg
│     ├─ 68ec55101b9a9_beautiful-mountains-landscape.jpg
│     ├─ 68f8655d15b20_index img.jpg
│     ├─ 68f985de3d84f_corte de cabello.jpg
│     ├─ 68f9863beea0c_corte de cabello.jpg
│     ├─ 68f98651c3ada_corte de cabello.jpg
│     ├─ 68f9868bbd904_corte de cabello.jpg
│     ├─ 68f986baefcb3_corte de cabello.jpg
│     ├─ 68f986e3458c9_teñir cab.jpg
│     ├─ 68f986ffc0180_corte de cabello.jpg
│     ├─ 68f987ec4a832_lavado de cabello.jpg
│     ├─ 68f98cb97de70_peinado.jpg
│     ├─ 68f99e82aa3bb_corte_de_cabello.jpg
│     ├─ 68f99eb1ca720_corte-barba.jpg
│     ├─ 68f99ff006af0_beautiful-mountains-landscape.jpg
│     ├─ 68f9a942eae62_peinado.jpg
│     ├─ 68f9ae08023cc_Espacios-pequenyos-mesas-comedor.jpg
│     ├─ 68f9ae40c5017_peinado.jpg
│     ├─ 68f9ae61a8ef4_Espacios-pequenyos-mesas-comedor.jpg
│     ├─ 68f9b4481d28f_barber_serv.jpg
│     ├─ 68fc008bb8369_platinado.jpg
│     ├─ 68fc009de76e6_platinado.jpg
│     ├─ 68fc00bd5d381_platinado.jpg
│     ├─ 68fc00f154bf0_platinado.jpg
│     ├─ 68fc013e2fe4c_platinado.jpg
│     ├─ 68fc01711ea55_platinado.jpg
│     ├─ 68fc01b2e1a1a_platinado.jpg
│     ├─ 68fc020d52da7_platinado.jpg
│     ├─ 68fc02b9cbae4_clasico_barba.jpeg
│     ├─ 68fc02f081d94_platinado.jpg
│     ├─ 68fc03666cc5d_platinado.jpg
│     ├─ 69017051a2892_brian_perfil.jpg
│     ├─ 6901705c8cc8f_brian_perfil.jpg
│     ├─ 690170d7dec23_brian_perfil.jpg
│     ├─ 6901713993628_brian_perfil.jpg
│     ├─ 6901978d8cf09_brian_perfil.jpg
│     ├─ 69022a7ae7168_brian_2.jpg
│     ├─ 6903f478ab3ca_brian_perfil.jpg
│     ├─ logo_barber1.png
│     ├─ section-1_1761109004.jpg
│     ├─ section-2_1761108971.jpg
│     ├─ section-3_1761109311.jpg
│     ├─ section-4_1761108991.jpg
│     └─ section-5_1761109211.jpg
├─ README.md
└─ vendor
   ├─ autoload.php
   ├─ composer
   │  ├─ autoload_classmap.php
   │  ├─ autoload_namespaces.php
   │  ├─ autoload_psr4.php
   │  ├─ autoload_real.php
   │  ├─ autoload_static.php
   │  ├─ ClassLoader.php
   │  ├─ installed.json
   │  ├─ installed.php
   │  ├─ InstalledVersions.php
   │  ├─ LICENSE
   │  └─ platform_check.php
   ├─ doctrine
   │  ├─ annotations
   │  │  ├─ composer.json
   │  │  ├─ docs
   │  │  │  └─ en
   │  │  │     ├─ annotations.rst
   │  │  │     ├─ custom.rst
   │  │  │     ├─ index.rst
   │  │  │     └─ sidebar.rst
   │  │  ├─ lib
   │  │  │  └─ Doctrine
   │  │  │     └─ Common
   │  │  │        └─ Annotations
   │  │  │           ├─ Annotation
   │  │  │           │  ├─ Attribute.php
   │  │  │           │  ├─ Attributes.php
   │  │  │           │  ├─ Enum.php
   │  │  │           │  ├─ IgnoreAnnotation.php
   │  │  │           │  ├─ NamedArgumentConstructor.php
   │  │  │           │  ├─ Required.php
   │  │  │           │  └─ Target.php
   │  │  │           ├─ Annotation.php
   │  │  │           ├─ AnnotationException.php
   │  │  │           ├─ AnnotationReader.php
   │  │  │           ├─ AnnotationRegistry.php
   │  │  │           ├─ CachedReader.php
   │  │  │           ├─ DocLexer.php
   │  │  │           ├─ DocParser.php
   │  │  │           ├─ FileCacheReader.php
   │  │  │           ├─ ImplicitlyIgnoredAnnotationNames.php
   │  │  │           ├─ IndexedReader.php
   │  │  │           ├─ NamedArgumentConstructorAnnotation.php
   │  │  │           ├─ PhpParser.php
   │  │  │           ├─ PsrCachedReader.php
   │  │  │           ├─ Reader.php
   │  │  │           ├─ SimpleAnnotationReader.php
   │  │  │           └─ TokenParser.php
   │  │  ├─ LICENSE
   │  │  ├─ psalm.xml
   │  │  └─ README.md
   │  ├─ common
   │  │  ├─ composer.json
   │  │  ├─ docs
   │  │  │  └─ en
   │  │  │     ├─ index.rst
   │  │  │     └─ reference
   │  │  │        └─ class-loading.rst
   │  │  ├─ LICENSE
   │  │  ├─ README.md
   │  │  ├─ src
   │  │  │  ├─ ClassLoader.php
   │  │  │  ├─ CommonException.php
   │  │  │  ├─ Comparable.php
   │  │  │  ├─ Proxy
   │  │  │  │  ├─ AbstractProxyFactory.php
   │  │  │  │  ├─ Autoloader.php
   │  │  │  │  ├─ Exception
   │  │  │  │  │  ├─ InvalidArgumentException.php
   │  │  │  │  │  ├─ OutOfBoundsException.php
   │  │  │  │  │  ├─ ProxyException.php
   │  │  │  │  │  └─ UnexpectedValueException.php
   │  │  │  │  ├─ Proxy.php
   │  │  │  │  ├─ ProxyDefinition.php
   │  │  │  │  └─ ProxyGenerator.php
   │  │  │  └─ Util
   │  │  │     ├─ ClassUtils.php
   │  │  │     └─ Debug.php
   │  │  ├─ UPGRADE_TO_2_1
   │  │  └─ UPGRADE_TO_2_2
   │  ├─ deprecations
   │  │  ├─ composer.json
   │  │  ├─ LICENSE
   │  │  ├─ README.md
   │  │  └─ src
   │  │     ├─ Deprecation.php
   │  │     └─ PHPUnit
   │  │        └─ VerifyDeprecations.php
   │  ├─ event-manager
   │  │  ├─ composer.json
   │  │  ├─ LICENSE
   │  │  ├─ phpstan.neon.dist
   │  │  ├─ psalm.xml
   │  │  ├─ README.md
   │  │  ├─ src
   │  │  │  ├─ EventArgs.php
   │  │  │  ├─ EventManager.php
   │  │  │  └─ EventSubscriber.php
   │  │  └─ UPGRADE.md
   │  ├─ lexer
   │  │  ├─ composer.json
   │  │  ├─ LICENSE
   │  │  ├─ README.md
   │  │  ├─ src
   │  │  │  ├─ AbstractLexer.php
   │  │  │  └─ Token.php
   │  │  └─ UPGRADE.md
   │  └─ persistence
   │     ├─ composer.json
   │     ├─ CONTRIBUTING.md
   │     ├─ LICENSE
   │     ├─ README.md
   │     ├─ src
   │     │  └─ Persistence
   │     │     ├─ AbstractManagerRegistry.php
   │     │     ├─ ConnectionRegistry.php
   │     │     ├─ Event
   │     │     │  ├─ LifecycleEventArgs.php
   │     │     │  ├─ LoadClassMetadataEventArgs.php
   │     │     │  ├─ ManagerEventArgs.php
   │     │     │  ├─ OnClearEventArgs.php
   │     │     │  └─ PreUpdateEventArgs.php
   │     │     ├─ ManagerRegistry.php
   │     │     ├─ Mapping
   │     │     │  ├─ AbstractClassMetadataFactory.php
   │     │     │  ├─ ClassMetadata.php
   │     │     │  ├─ ClassMetadataFactory.php
   │     │     │  ├─ Driver
   │     │     │  │  ├─ ColocatedMappingDriver.php
   │     │     │  │  ├─ DefaultFileLocator.php
   │     │     │  │  ├─ FileDriver.php
   │     │     │  │  ├─ FileLocator.php
   │     │     │  │  ├─ MappingDriver.php
   │     │     │  │  ├─ MappingDriverChain.php
   │     │     │  │  ├─ PHPDriver.php
   │     │     │  │  ├─ StaticPHPDriver.php
   │     │     │  │  └─ SymfonyFileLocator.php
   │     │     │  ├─ MappingException.php
   │     │     │  ├─ ProxyClassNameResolver.php
   │     │     │  ├─ ReflectionService.php
   │     │     │  ├─ RuntimeReflectionService.php
   │     │     │  └─ StaticReflectionService.php
   │     │     ├─ NotifyPropertyChanged.php
   │     │     ├─ ObjectManager.php
   │     │     ├─ ObjectManagerDecorator.php
   │     │     ├─ ObjectRepository.php
   │     │     ├─ PropertyChangedListener.php
   │     │     ├─ Proxy.php
   │     │     └─ Reflection
   │     │        ├─ EnumReflectionProperty.php
   │     │        ├─ RuntimePublicReflectionProperty.php
   │     │        ├─ RuntimeReflectionProperty.php
   │     │        ├─ TypedNoDefaultReflectionProperty.php
   │     │        ├─ TypedNoDefaultReflectionPropertyBase.php
   │     │        └─ TypedNoDefaultRuntimePublicReflectionProperty.php
   │     └─ UPGRADE.md
   ├─ mercadopago
   │  └─ dx-php
   │     ├─ .travis.yml
   │     ├─ composer.json
   │     ├─ img
   │     │  ├─ demo.svg
   │     │  └─ ezgif-2-f98e8701825e.gif
   │     ├─ LICENSE
   │     ├─ phpunit.phar
   │     ├─ phpunit.xml
   │     ├─ README.md
   │     ├─ samples
   │     │  ├─ checkout-buttons
   │     │  │  ├─ basic-preference
   │     │  │  │  └─ button.php
   │     │  │  └─ full-preference
   │     │  │     └─ button.php
   │     │  ├─ composer.json
   │     │  ├─ composer.lock
   │     │  ├─ customer-and-cards
   │     │  │  ├─ card
   │     │  │  │  └─ list.php
   │     │  │  └─ customer
   │     │  │     ├─ create.php
   │     │  │     └─ remove.php
   │     │  ├─ index.php
   │     │  ├─ payment
   │     │  │  └─ minimal
   │     │  │     ├─ create.php
   │     │  │     └─ refund.php
   │     │  └─ suscriptions
   │     │     └─ basic-suscription.php
   │     ├─ src
   │     │  └─ MercadoPago
   │     │     ├─ Annotation
   │     │     │  ├─ Attribute.php
   │     │     │  ├─ DenyDynamicAttribute.php
   │     │     │  ├─ RequestParam.php
   │     │     │  └─ RestMethod.php
   │     │     ├─ Config
   │     │     │  ├─ AbstractConfig.php
   │     │     │  ├─ Json.php
   │     │     │  ├─ ParserInterface.php
   │     │     │  └─ Yaml.php
   │     │     ├─ Config.php
   │     │     ├─ Entities
   │     │     │  ├─ AdvancedPayments
   │     │     │  │  ├─ AdvancedPayment.php
   │     │     │  │  ├─ DisbursementRefund.php
   │     │     │  │  └─ Refund.php
   │     │     │  ├─ AuthorizedPayment.php
   │     │     │  ├─ Card.php
   │     │     │  ├─ CardToken.php
   │     │     │  ├─ Chargeback.php
   │     │     │  ├─ Customer.php
   │     │     │  ├─ DiscountCampaign.php
   │     │     │  ├─ InstoreOrder.php
   │     │     │  ├─ Invoice.php
   │     │     │  ├─ MerchantOrder.php
   │     │     │  ├─ OAuth.php
   │     │     │  ├─ Plan.php
   │     │     │  ├─ POS.php
   │     │     │  ├─ Preapproval.php
   │     │     │  ├─ Preference.php
   │     │     │  ├─ Refund.php
   │     │     │  ├─ Shared
   │     │     │  │  ├─ Documentation.php
   │     │     │  │  ├─ Item.php
   │     │     │  │  ├─ Payer.php
   │     │     │  │  ├─ Payment.php
   │     │     │  │  ├─ PaymentMethod.php
   │     │     │  │  ├─ Tax.php
   │     │     │  │  ├─ Track.php
   │     │     │  │  └─ TrackValues.php
   │     │     │  ├─ Shipments.php
   │     │     │  └─ Subscription.php
   │     │     ├─ Entity.php
   │     │     ├─ Generic
   │     │     │  ├─ ErrorCause.php
   │     │     │  ├─ RecuperableError.php
   │     │     │  └─ SearchResultsArray.php
   │     │     ├─ Http
   │     │     │  ├─ CurlRequest.php
   │     │     │  └─ HttpRequest.php
   │     │     ├─ Manager.php
   │     │     ├─ MetaDataReader.php
   │     │     ├─ RestClient.php
   │     │     ├─ SDK.php
   │     │     └─ Version.php
   │     └─ tests
   │        ├─ config_files
   │        │  ├─ settings.ini
   │        │  ├─ settings.json
   │        │  ├─ settings.yml
   │        │  ├─ settings_broken.json
   │        │  └─ settings_broken.yml
   │        ├─ DummyEntity.php
   │        ├─ FakeApiHub.php
   │        ├─ json_files
   │        │  ├─ authorization.json
   │        │  ├─ customer_search.json
   │        │  ├─ dummies.json
   │        │  ├─ dummy.json
   │        │  └─ payment.json
   │        ├─ MercadoPagoSdkTest.php
   │        ├─ resources
   │        │  ├─ PaymentTest.php
   │        │  └─ PreferenceTest.php
   │        └─ SDKTest.php
   └─ psr
      └─ cache
         ├─ CHANGELOG.md
         ├─ composer.json
         ├─ LICENSE.txt
         ├─ README.md
         └─ src
            ├─ CacheException.php
            ├─ CacheItemInterface.php
            ├─ CacheItemPoolInterface.php
            └─ InvalidArgumentException.php

```
```
grok
├─ composer.json
├─ composer.lock
├─ contenedores_db (7).sql
├─ css
│  ├─ index.css
│  ├─ registro.css
│  ├─ servicio.css
│  ├─ servicios1.css
│  └─ turno.css
├─ html
│  └─ registro.html
├─ js
├─ php
│  ├─ admin
│  │  ├─ barba_admin.php
│  │  ├─ corte_admin.php
│  │  ├─ lavado_admin.php
│  │  ├─ peinado_admin.php
│  │  ├─ tintura_admin.php
│  │  └─ turnos_admin.php
│  ├─ cancelar_turno.php
│  ├─ conexion.php
│  ├─ config_admin.php
│  ├─ crear_preferencia.php
│  ├─ descargar_comprobante.php
│  ├─ dompdf
│  │  ├─ AUTHORS.md
│  │  ├─ autoload.inc.php
│  │  ├─ LICENSE.LGPL
│  │  ├─ README.md
│  │  ├─ vendor
│  │  │  ├─ autoload.php
│  │  │  ├─ composer
│  │  │  │  ├─ autoload_classmap.php
│  │  │  │  ├─ autoload_namespaces.php
│  │  │  │  ├─ autoload_psr4.php
│  │  │  │  ├─ autoload_real.php
│  │  │  │  ├─ autoload_static.php
│  │  │  │  ├─ ClassLoader.php
│  │  │  │  ├─ installed.json
│  │  │  │  ├─ installed.php
│  │  │  │  ├─ InstalledVersions.php
│  │  │  │  ├─ LICENSE
│  │  │  │  └─ platform_check.php
│  │  │  ├─ dompdf
│  │  │  │  ├─ dompdf
│  │  │  │  │  ├─ AUTHORS.md
│  │  │  │  │  ├─ composer.json
│  │  │  │  │  ├─ lib
│  │  │  │  │  │  ├─ Cpdf.php
│  │  │  │  │  │  ├─ fonts
│  │  │  │  │  │  │  ├─ Courier-Bold.afm
│  │  │  │  │  │  │  ├─ Courier-BoldOblique.afm
│  │  │  │  │  │  │  ├─ Courier-Oblique.afm
│  │  │  │  │  │  │  ├─ Courier.afm
│  │  │  │  │  │  │  ├─ DejaVuSans-Bold.ttf
│  │  │  │  │  │  │  ├─ DejaVuSans-Bold.ufm
│  │  │  │  │  │  │  ├─ DejaVuSans-BoldOblique.ttf
│  │  │  │  │  │  │  ├─ DejaVuSans-BoldOblique.ufm
│  │  │  │  │  │  │  ├─ DejaVuSans-Oblique.ttf
│  │  │  │  │  │  │  ├─ DejaVuSans-Oblique.ufm
│  │  │  │  │  │  │  ├─ DejaVuSans.ttf
│  │  │  │  │  │  │  ├─ DejaVuSans.ufm
│  │  │  │  │  │  │  ├─ DejaVuSansMono-Bold.ttf
│  │  │  │  │  │  │  ├─ DejaVuSansMono-Bold.ufm
│  │  │  │  │  │  │  ├─ DejaVuSansMono-BoldOblique.ttf
│  │  │  │  │  │  │  ├─ DejaVuSansMono-BoldOblique.ufm
│  │  │  │  │  │  │  ├─ DejaVuSansMono-Oblique.ttf
│  │  │  │  │  │  │  ├─ DejaVuSansMono-Oblique.ufm
│  │  │  │  │  │  │  ├─ DejaVuSansMono.ttf
│  │  │  │  │  │  │  ├─ DejaVuSansMono.ufm
│  │  │  │  │  │  │  ├─ DejaVuSerif-Bold.ttf
│  │  │  │  │  │  │  ├─ DejaVuSerif-Bold.ufm
│  │  │  │  │  │  │  ├─ DejaVuSerif-BoldItalic.ttf
│  │  │  │  │  │  │  ├─ DejaVuSerif-BoldItalic.ufm
│  │  │  │  │  │  │  ├─ DejaVuSerif-Italic.ttf
│  │  │  │  │  │  │  ├─ DejaVuSerif-Italic.ufm
│  │  │  │  │  │  │  ├─ DejaVuSerif.ttf
│  │  │  │  │  │  │  ├─ DejaVuSerif.ufm
│  │  │  │  │  │  │  ├─ Helvetica-Bold.afm
│  │  │  │  │  │  │  ├─ Helvetica-Bold.afm.json
│  │  │  │  │  │  │  ├─ Helvetica-BoldOblique.afm
│  │  │  │  │  │  │  ├─ Helvetica-BoldOblique.afm.json
│  │  │  │  │  │  │  ├─ Helvetica-Oblique.afm
│  │  │  │  │  │  │  ├─ Helvetica-Oblique.afm.json
│  │  │  │  │  │  │  ├─ Helvetica.afm
│  │  │  │  │  │  │  ├─ Helvetica.afm.json
│  │  │  │  │  │  │  ├─ installed-fonts.dist.json
│  │  │  │  │  │  │  ├─ mustRead.html
│  │  │  │  │  │  │  ├─ Symbol.afm
│  │  │  │  │  │  │  ├─ Times-Bold.afm
│  │  │  │  │  │  │  ├─ Times-BoldItalic.afm
│  │  │  │  │  │  │  ├─ Times-Italic.afm
│  │  │  │  │  │  │  ├─ Times-Roman.afm
│  │  │  │  │  │  │  └─ ZapfDingbats.afm
│  │  │  │  │  │  └─ res
│  │  │  │  │  │     ├─ broken_image.png
│  │  │  │  │  │     ├─ broken_image.svg
│  │  │  │  │  │     ├─ html.css
│  │  │  │  │  │     ├─ sRGB2014.icc
│  │  │  │  │  │     └─ sRGB2014.icc.LICENSE
│  │  │  │  │  ├─ LICENSE.LGPL
│  │  │  │  │  ├─ phpunit.xml
│  │  │  │  │  ├─ README.md
│  │  │  │  │  ├─ src
│  │  │  │  │  │  ├─ Adapter
│  │  │  │  │  │  │  ├─ CPDF.php
│  │  │  │  │  │  │  ├─ GD.php
│  │  │  │  │  │  │  └─ PDFLib.php
│  │  │  │  │  │  ├─ Canvas.php
│  │  │  │  │  │  ├─ CanvasFactory.php
│  │  │  │  │  │  ├─ Cellmap.php
│  │  │  │  │  │  ├─ Css
│  │  │  │  │  │  │  ├─ AttributeTranslator.php
│  │  │  │  │  │  │  ├─ Color.php
│  │  │  │  │  │  │  ├─ Content
│  │  │  │  │  │  │  │  ├─ Attr.php
│  │  │  │  │  │  │  │  ├─ CloseQuote.php
│  │  │  │  │  │  │  │  ├─ ContentPart.php
│  │  │  │  │  │  │  │  ├─ Counter.php
│  │  │  │  │  │  │  │  ├─ Counters.php
│  │  │  │  │  │  │  │  ├─ NoCloseQuote.php
│  │  │  │  │  │  │  │  ├─ NoOpenQuote.php
│  │  │  │  │  │  │  │  ├─ OpenQuote.php
│  │  │  │  │  │  │  │  ├─ StringPart.php
│  │  │  │  │  │  │  │  └─ Url.php
│  │  │  │  │  │  │  ├─ Style.php
│  │  │  │  │  │  │  └─ Stylesheet.php
│  │  │  │  │  │  ├─ Dompdf.php
│  │  │  │  │  │  ├─ Exception
│  │  │  │  │  │  │  └─ ImageException.php
│  │  │  │  │  │  ├─ Exception.php
│  │  │  │  │  │  ├─ FontMetrics.php
│  │  │  │  │  │  ├─ Frame
│  │  │  │  │  │  │  ├─ Factory.php
│  │  │  │  │  │  │  ├─ FrameListIterator.php
│  │  │  │  │  │  │  ├─ FrameTree.php
│  │  │  │  │  │  │  └─ FrameTreeIterator.php
│  │  │  │  │  │  ├─ Frame.php
│  │  │  │  │  │  ├─ FrameDecorator
│  │  │  │  │  │  │  ├─ AbstractFrameDecorator.php
│  │  │  │  │  │  │  ├─ Block.php
│  │  │  │  │  │  │  ├─ Image.php
│  │  │  │  │  │  │  ├─ Inline.php
│  │  │  │  │  │  │  ├─ ListBullet.php
│  │  │  │  │  │  │  ├─ ListBulletImage.php
│  │  │  │  │  │  │  ├─ NullFrameDecorator.php
│  │  │  │  │  │  │  ├─ Page.php
│  │  │  │  │  │  │  ├─ Table.php
│  │  │  │  │  │  │  ├─ TableCell.php
│  │  │  │  │  │  │  ├─ TableRow.php
│  │  │  │  │  │  │  ├─ TableRowGroup.php
│  │  │  │  │  │  │  └─ Text.php
│  │  │  │  │  │  ├─ FrameReflower
│  │  │  │  │  │  │  ├─ AbstractFrameReflower.php
│  │  │  │  │  │  │  ├─ Block.php
│  │  │  │  │  │  │  ├─ Image.php
│  │  │  │  │  │  │  ├─ Inline.php
│  │  │  │  │  │  │  ├─ ListBullet.php
│  │  │  │  │  │  │  ├─ NullFrameReflower.php
│  │  │  │  │  │  │  ├─ Page.php
│  │  │  │  │  │  │  ├─ Table.php
│  │  │  │  │  │  │  ├─ TableCell.php
│  │  │  │  │  │  │  ├─ TableRow.php
│  │  │  │  │  │  │  ├─ TableRowGroup.php
│  │  │  │  │  │  │  └─ Text.php
│  │  │  │  │  │  ├─ Helpers.php
│  │  │  │  │  │  ├─ Image
│  │  │  │  │  │  │  └─ Cache.php
│  │  │  │  │  │  ├─ JavascriptEmbedder.php
│  │  │  │  │  │  ├─ LineBox.php
│  │  │  │  │  │  ├─ Options.php
│  │  │  │  │  │  ├─ PhpEvaluator.php
│  │  │  │  │  │  ├─ Positioner
│  │  │  │  │  │  │  ├─ Absolute.php
│  │  │  │  │  │  │  ├─ AbstractPositioner.php
│  │  │  │  │  │  │  ├─ Block.php
│  │  │  │  │  │  │  ├─ Fixed.php
│  │  │  │  │  │  │  ├─ Inline.php
│  │  │  │  │  │  │  ├─ ListBullet.php
│  │  │  │  │  │  │  ├─ NullPositioner.php
│  │  │  │  │  │  │  ├─ TableCell.php
│  │  │  │  │  │  │  └─ TableRow.php
│  │  │  │  │  │  ├─ Renderer
│  │  │  │  │  │  │  ├─ AbstractRenderer.php
│  │  │  │  │  │  │  ├─ Block.php
│  │  │  │  │  │  │  ├─ Image.php
│  │  │  │  │  │  │  ├─ Inline.php
│  │  │  │  │  │  │  ├─ ListBullet.php
│  │  │  │  │  │  │  ├─ TableCell.php
│  │  │  │  │  │  │  ├─ TableRow.php
│  │  │  │  │  │  │  ├─ TableRowGroup.php
│  │  │  │  │  │  │  └─ Text.php
│  │  │  │  │  │  └─ Renderer.php
│  │  │  │  │  └─ VERSION
│  │  │  │  ├─ php-font-lib
│  │  │  │  │  ├─ AUTHORS.md
│  │  │  │  │  ├─ composer.json
│  │  │  │  │  ├─ LICENSE
│  │  │  │  │  ├─ maps
│  │  │  │  │  │  ├─ adobe-standard-encoding.map
│  │  │  │  │  │  ├─ cp1250.map
│  │  │  │  │  │  ├─ cp1251.map
│  │  │  │  │  │  ├─ cp1252.map
│  │  │  │  │  │  ├─ cp1253.map
│  │  │  │  │  │  ├─ cp1254.map
│  │  │  │  │  │  ├─ cp1255.map
│  │  │  │  │  │  ├─ cp1257.map
│  │  │  │  │  │  ├─ cp1258.map
│  │  │  │  │  │  ├─ cp874.map
│  │  │  │  │  │  ├─ iso-8859-1.map
│  │  │  │  │  │  ├─ iso-8859-11.map
│  │  │  │  │  │  ├─ iso-8859-15.map
│  │  │  │  │  │  ├─ iso-8859-16.map
│  │  │  │  │  │  ├─ iso-8859-2.map
│  │  │  │  │  │  ├─ iso-8859-4.map
│  │  │  │  │  │  ├─ iso-8859-5.map
│  │  │  │  │  │  ├─ iso-8859-7.map
│  │  │  │  │  │  ├─ iso-8859-9.map
│  │  │  │  │  │  ├─ koi8-r.map
│  │  │  │  │  │  └─ koi8-u.map
│  │  │  │  │  ├─ README.md
│  │  │  │  │  └─ src
│  │  │  │  │     └─ FontLib
│  │  │  │  │        ├─ AdobeFontMetrics.php
│  │  │  │  │        ├─ BinaryStream.php
│  │  │  │  │        ├─ EncodingMap.php
│  │  │  │  │        ├─ EOT
│  │  │  │  │        │  ├─ File.php
│  │  │  │  │        │  └─ Header.php
│  │  │  │  │        ├─ Exception
│  │  │  │  │        │  └─ FontNotFoundException.php
│  │  │  │  │        ├─ Font.php
│  │  │  │  │        ├─ Glyph
│  │  │  │  │        │  ├─ Outline.php
│  │  │  │  │        │  ├─ OutlineComponent.php
│  │  │  │  │        │  ├─ OutlineComposite.php
│  │  │  │  │        │  └─ OutlineSimple.php
│  │  │  │  │        ├─ Header.php
│  │  │  │  │        ├─ OpenType
│  │  │  │  │        │  ├─ File.php
│  │  │  │  │        │  └─ TableDirectoryEntry.php
│  │  │  │  │        ├─ Table
│  │  │  │  │        │  ├─ DirectoryEntry.php
│  │  │  │  │        │  ├─ Table.php
│  │  │  │  │        │  └─ Type
│  │  │  │  │        │     ├─ cmap.php
│  │  │  │  │        │     ├─ cvt.php
│  │  │  │  │        │     ├─ fpgm.php
│  │  │  │  │        │     ├─ glyf.php
│  │  │  │  │        │     ├─ head.php
│  │  │  │  │        │     ├─ hhea.php
│  │  │  │  │        │     ├─ hmtx.php
│  │  │  │  │        │     ├─ kern.php
│  │  │  │  │        │     ├─ loca.php
│  │  │  │  │        │     ├─ maxp.php
│  │  │  │  │        │     ├─ name.php
│  │  │  │  │        │     ├─ nameRecord.php
│  │  │  │  │        │     ├─ os2.php
│  │  │  │  │        │     ├─ post.php
│  │  │  │  │        │     └─ prep.php
│  │  │  │  │        ├─ TrueType
│  │  │  │  │        │  ├─ Collection.php
│  │  │  │  │        │  ├─ File.php
│  │  │  │  │        │  ├─ Header.php
│  │  │  │  │        │  └─ TableDirectoryEntry.php
│  │  │  │  │        └─ WOFF
│  │  │  │  │           ├─ File.php
│  │  │  │  │           ├─ Header.php
│  │  │  │  │           └─ TableDirectoryEntry.php
│  │  │  │  └─ php-svg-lib
│  │  │  │     ├─ AUTHORS.md
│  │  │  │     ├─ composer.json
│  │  │  │     ├─ LICENSE
│  │  │  │     ├─ README.md
│  │  │  │     └─ src
│  │  │  │        └─ Svg
│  │  │  │           ├─ CssLength.php
│  │  │  │           ├─ DefaultStyle.php
│  │  │  │           ├─ Document.php
│  │  │  │           ├─ Gradient
│  │  │  │           │  └─ Stop.php
│  │  │  │           ├─ Style.php
│  │  │  │           ├─ Surface
│  │  │  │           │  ├─ CPdf.php
│  │  │  │           │  ├─ SurfaceCpdf.php
│  │  │  │           │  ├─ SurfaceInterface.php
│  │  │  │           │  └─ SurfacePDFLib.php
│  │  │  │           └─ Tag
│  │  │  │              ├─ AbstractTag.php
│  │  │  │              ├─ Anchor.php
│  │  │  │              ├─ Circle.php
│  │  │  │              ├─ ClipPath.php
│  │  │  │              ├─ Ellipse.php
│  │  │  │              ├─ Group.php
│  │  │  │              ├─ Image.php
│  │  │  │              ├─ Line.php
│  │  │  │              ├─ LinearGradient.php
│  │  │  │              ├─ Path.php
│  │  │  │              ├─ Polygon.php
│  │  │  │              ├─ Polyline.php
│  │  │  │              ├─ RadialGradient.php
│  │  │  │              ├─ Rect.php
│  │  │  │              ├─ Shape.php
│  │  │  │              ├─ Stop.php
│  │  │  │              ├─ StyleTag.php
│  │  │  │              ├─ Symbol.php
│  │  │  │              ├─ Text.php
│  │  │  │              └─ UseTag.php
│  │  │  ├─ masterminds
│  │  │  │  └─ html5
│  │  │  │     ├─ bin
│  │  │  │     │  └─ entities.php
│  │  │  │     ├─ composer.json
│  │  │  │     ├─ CREDITS
│  │  │  │     ├─ LICENSE.txt
│  │  │  │     ├─ README.md
│  │  │  │     ├─ RELEASE.md
│  │  │  │     ├─ src
│  │  │  │     │  ├─ HTML5
│  │  │  │     │  │  ├─ Elements.php
│  │  │  │     │  │  ├─ Entities.php
│  │  │  │     │  │  ├─ Exception.php
│  │  │  │     │  │  ├─ InstructionProcessor.php
│  │  │  │     │  │  ├─ Parser
│  │  │  │     │  │  │  ├─ CharacterReference.php
│  │  │  │     │  │  │  ├─ DOMTreeBuilder.php
│  │  │  │     │  │  │  ├─ EventHandler.php
│  │  │  │     │  │  │  ├─ FileInputStream.php
│  │  │  │     │  │  │  ├─ InputStream.php
│  │  │  │     │  │  │  ├─ ParseError.php
│  │  │  │     │  │  │  ├─ README.md
│  │  │  │     │  │  │  ├─ Scanner.php
│  │  │  │     │  │  │  ├─ StringInputStream.php
│  │  │  │     │  │  │  ├─ Tokenizer.php
│  │  │  │     │  │  │  ├─ TreeBuildingRules.php
│  │  │  │     │  │  │  └─ UTF8Utils.php
│  │  │  │     │  │  └─ Serializer
│  │  │  │     │  │     ├─ HTML5Entities.php
│  │  │  │     │  │     ├─ OutputRules.php
│  │  │  │     │  │     ├─ README.md
│  │  │  │     │  │     ├─ RulesInterface.php
│  │  │  │     │  │     └─ Traverser.php
│  │  │  │     │  └─ HTML5.php
│  │  │  │     └─ UPGRADING.md
│  │  │  └─ sabberworm
│  │  │     └─ php-css-parser
│  │  │        ├─ CHANGELOG.md
│  │  │        ├─ composer.json
│  │  │        ├─ LICENSE
│  │  │        ├─ README.md
│  │  │        └─ src
│  │  │           ├─ Comment
│  │  │           │  ├─ Comment.php
│  │  │           │  └─ Commentable.php
│  │  │           ├─ CSSElement.php
│  │  │           ├─ CSSList
│  │  │           │  ├─ AtRuleBlockList.php
│  │  │           │  ├─ CSSBlockList.php
│  │  │           │  ├─ CSSList.php
│  │  │           │  ├─ Document.php
│  │  │           │  └─ KeyFrame.php
│  │  │           ├─ OutputFormat.php
│  │  │           ├─ OutputFormatter.php
│  │  │           ├─ Parser.php
│  │  │           ├─ Parsing
│  │  │           │  ├─ Anchor.php
│  │  │           │  ├─ OutputException.php
│  │  │           │  ├─ ParserState.php
│  │  │           │  ├─ SourceException.php
│  │  │           │  ├─ UnexpectedEOFException.php
│  │  │           │  └─ UnexpectedTokenException.php
│  │  │           ├─ Position
│  │  │           │  ├─ Position.php
│  │  │           │  └─ Positionable.php
│  │  │           ├─ Property
│  │  │           │  ├─ AtRule.php
│  │  │           │  ├─ Charset.php
│  │  │           │  ├─ CSSNamespace.php
│  │  │           │  ├─ Import.php
│  │  │           │  ├─ KeyframeSelector.php
│  │  │           │  └─ Selector.php
│  │  │           ├─ Renderable.php
│  │  │           ├─ Rule
│  │  │           │  └─ Rule.php
│  │  │           ├─ RuleSet
│  │  │           │  ├─ AtRuleSet.php
│  │  │           │  ├─ DeclarationBlock.php
│  │  │           │  └─ RuleSet.php
│  │  │           ├─ Settings.php
│  │  │           └─ Value
│  │  │              ├─ CalcFunction.php
│  │  │              ├─ CalcRuleValueList.php
│  │  │              ├─ Color.php
│  │  │              ├─ CSSFunction.php
│  │  │              ├─ CSSString.php
│  │  │              ├─ LineName.php
│  │  │              ├─ PrimitiveValue.php
│  │  │              ├─ RuleValueList.php
│  │  │              ├─ Size.php
│  │  │              ├─ URL.php
│  │  │              ├─ Value.php
│  │  │              └─ ValueList.php
│  │  └─ VERSION
│  ├─ fetch_config_por_dia.php
│  ├─ fetch_historial_turnos.php
│  ├─ fetch_horarios_disponibles.php
│  ├─ fetch_subservicios.php
│  ├─ fetch_turnos_ocupados.php
│  ├─ fetch_turnos_por_dia.php
│  ├─ generate_horarios.php
│  ├─ guardar_barba.php
│  ├─ guardar_corte.php
│  ├─ guardar_foto.php
│  ├─ guardar_intro.php
│  ├─ guardar_lavado.php
│  ├─ guardar_peinado.php
│  ├─ guardar_portada.php
│  ├─ guardar_servicio.php
│  ├─ guardar_tintura.php
│  ├─ guardar_turno.php
│  ├─ index_admin.php
│  ├─ index_cliente.php
│  ├─ index_principal.php
│  ├─ mercado_pago.php
│  ├─ mis_turnos.php
│  ├─ mp_config.php
│  ├─ mp_error_log.txt
│  ├─ php_error_log.txt
│  ├─ procesar_login.php
│  ├─ procesar_pago.php
│  ├─ procesar_recuperacion.php
│  ├─ procesar_registro.php
│  ├─ reset_password.php
│  ├─ servicios
│  │  ├─ barba.php
│  │  ├─ barba_publico.php
│  │  ├─ corte.php
│  │  ├─ corte_publico.php
│  │  ├─ lavado.php
│  │  ├─ lavado_publico.php
│  │  ├─ peinado.php
│  │  ├─ peinado_publico.php
│  │  ├─ tintura.php
│  │  └─ tintura_publico.php
│  ├─ turno.php
│  ├─ turnos_admin.php
│  ├─ uploads
│  │  ├─ 68e40e9945e1f_index img.jpg
│  │  ├─ 68ec452974f25_illustration-anime-character-rain.jpg
│  │  ├─ 68ec45d473cf8_illustration-anime-character-rain.jpg
│  │  ├─ 68ec47e0a5554_illustration-anime-character-rain.jpg
│  │  ├─ 68ec48c6af93a_illustration-anime-character-rain.jpg
│  │  ├─ 68ec4ac57764e_illustration-anime-character-rain.jpg
│  │  ├─ 68ec55101b9a9_beautiful-mountains-landscape.jpg
│  │  ├─ 68f8655d15b20_index img.jpg
│  │  ├─ 68f985de3d84f_corte de cabello.jpg
│  │  ├─ 68f9863beea0c_corte de cabello.jpg
│  │  ├─ 68f98651c3ada_corte de cabello.jpg
│  │  ├─ 68f9868bbd904_corte de cabello.jpg
│  │  ├─ 68f986baefcb3_corte de cabello.jpg
│  │  ├─ 68f986e3458c9_teñir cab.jpg
│  │  ├─ 68f986ffc0180_corte de cabello.jpg
│  │  ├─ 68f987ec4a832_lavado de cabello.jpg
│  │  ├─ 68f98cb97de70_peinado.jpg
│  │  ├─ 68f99e82aa3bb_corte_de_cabello.jpg
│  │  ├─ 68f99eb1ca720_corte-barba.jpg
│  │  ├─ 68f99ff006af0_beautiful-mountains-landscape.jpg
│  │  ├─ 68f9a942eae62_peinado.jpg
│  │  ├─ 68f9ae08023cc_Espacios-pequenyos-mesas-comedor.jpg
│  │  ├─ 68f9ae40c5017_peinado.jpg
│  │  ├─ 68f9ae61a8ef4_Espacios-pequenyos-mesas-comedor.jpg
│  │  ├─ 68f9b4481d28f_barber_serv.jpg
│  │  ├─ 68fc008bb8369_platinado.jpg
│  │  ├─ 68fc009de76e6_platinado.jpg
│  │  ├─ 68fc00bd5d381_platinado.jpg
│  │  ├─ 68fc00f154bf0_platinado.jpg
│  │  ├─ 68fc013e2fe4c_platinado.jpg
│  │  ├─ 68fc01711ea55_platinado.jpg
│  │  ├─ 68fc01b2e1a1a_platinado.jpg
│  │  ├─ 68fc020d52da7_platinado.jpg
│  │  ├─ 68fc02b9cbae4_clasico_barba.jpeg
│  │  ├─ 68fc02f081d94_platinado.jpg
│  │  ├─ 68fc03666cc5d_platinado.jpg
│  │  ├─ 69017051a2892_brian_perfil.jpg
│  │  ├─ 6901705c8cc8f_brian_perfil.jpg
│  │  ├─ 690170d7dec23_brian_perfil.jpg
│  │  ├─ 6901713993628_brian_perfil.jpg
│  │  ├─ 6901978d8cf09_brian_perfil.jpg
│  │  ├─ 69022a7ae7168_brian_2.jpg
│  │  ├─ 6903f478ab3ca_brian_perfil.jpg
│  │  ├─ logo_barber1.png
│  │  ├─ section-1_1761109004.jpg
│  │  ├─ section-2_1761108971.jpg
│  │  ├─ section-3_1761109311.jpg
│  │  ├─ section-4_1761108991.jpg
│  │  └─ section-5_1761109211.jpg
│  └─ webhook.php
├─ README.md
└─ vendor
   ├─ autoload.php
   ├─ composer
   │  ├─ autoload_classmap.php
   │  ├─ autoload_namespaces.php
   │  ├─ autoload_psr4.php
   │  ├─ autoload_real.php
   │  ├─ autoload_static.php
   │  ├─ ClassLoader.php
   │  ├─ installed.json
   │  ├─ installed.php
   │  ├─ InstalledVersions.php
   │  ├─ LICENSE
   │  └─ platform_check.php
   ├─ doctrine
   │  ├─ annotations
   │  │  ├─ composer.json
   │  │  ├─ docs
   │  │  │  └─ en
   │  │  │     ├─ annotations.rst
   │  │  │     ├─ custom.rst
   │  │  │     ├─ index.rst
   │  │  │     └─ sidebar.rst
   │  │  ├─ lib
   │  │  │  └─ Doctrine
   │  │  │     └─ Common
   │  │  │        └─ Annotations
   │  │  │           ├─ Annotation
   │  │  │           │  ├─ Attribute.php
   │  │  │           │  ├─ Attributes.php
   │  │  │           │  ├─ Enum.php
   │  │  │           │  ├─ IgnoreAnnotation.php
   │  │  │           │  ├─ NamedArgumentConstructor.php
   │  │  │           │  ├─ Required.php
   │  │  │           │  └─ Target.php
   │  │  │           ├─ Annotation.php
   │  │  │           ├─ AnnotationException.php
   │  │  │           ├─ AnnotationReader.php
   │  │  │           ├─ AnnotationRegistry.php
   │  │  │           ├─ CachedReader.php
   │  │  │           ├─ DocLexer.php
   │  │  │           ├─ DocParser.php
   │  │  │           ├─ FileCacheReader.php
   │  │  │           ├─ ImplicitlyIgnoredAnnotationNames.php
   │  │  │           ├─ IndexedReader.php
   │  │  │           ├─ NamedArgumentConstructorAnnotation.php
   │  │  │           ├─ PhpParser.php
   │  │  │           ├─ PsrCachedReader.php
   │  │  │           ├─ Reader.php
   │  │  │           ├─ SimpleAnnotationReader.php
   │  │  │           └─ TokenParser.php
   │  │  ├─ LICENSE
   │  │  ├─ psalm.xml
   │  │  └─ README.md
   │  ├─ common
   │  │  ├─ composer.json
   │  │  ├─ docs
   │  │  │  └─ en
   │  │  │     ├─ index.rst
   │  │  │     └─ reference
   │  │  │        └─ class-loading.rst
   │  │  ├─ LICENSE
   │  │  ├─ README.md
   │  │  ├─ src
   │  │  │  ├─ ClassLoader.php
   │  │  │  ├─ CommonException.php
   │  │  │  ├─ Comparable.php
   │  │  │  ├─ Proxy
   │  │  │  │  ├─ AbstractProxyFactory.php
   │  │  │  │  ├─ Autoloader.php
   │  │  │  │  ├─ Exception
   │  │  │  │  │  ├─ InvalidArgumentException.php
   │  │  │  │  │  ├─ OutOfBoundsException.php
   │  │  │  │  │  ├─ ProxyException.php
   │  │  │  │  │  └─ UnexpectedValueException.php
   │  │  │  │  ├─ Proxy.php
   │  │  │  │  ├─ ProxyDefinition.php
   │  │  │  │  └─ ProxyGenerator.php
   │  │  │  └─ Util
   │  │  │     ├─ ClassUtils.php
   │  │  │     └─ Debug.php
   │  │  ├─ UPGRADE_TO_2_1
   │  │  └─ UPGRADE_TO_2_2
   │  ├─ deprecations
   │  │  ├─ composer.json
   │  │  ├─ LICENSE
   │  │  ├─ README.md
   │  │  └─ src
   │  │     ├─ Deprecation.php
   │  │     └─ PHPUnit
   │  │        └─ VerifyDeprecations.php
   │  ├─ event-manager
   │  │  ├─ composer.json
   │  │  ├─ LICENSE
   │  │  ├─ phpstan.neon.dist
   │  │  ├─ psalm.xml
   │  │  ├─ README.md
   │  │  ├─ src
   │  │  │  ├─ EventArgs.php
   │  │  │  ├─ EventManager.php
   │  │  │  └─ EventSubscriber.php
   │  │  └─ UPGRADE.md
   │  ├─ lexer
   │  │  ├─ composer.json
   │  │  ├─ LICENSE
   │  │  ├─ README.md
   │  │  ├─ src
   │  │  │  ├─ AbstractLexer.php
   │  │  │  └─ Token.php
   │  │  └─ UPGRADE.md
   │  └─ persistence
   │     ├─ composer.json
   │     ├─ CONTRIBUTING.md
   │     ├─ LICENSE
   │     ├─ README.md
   │     ├─ src
   │     │  └─ Persistence
   │     │     ├─ AbstractManagerRegistry.php
   │     │     ├─ ConnectionRegistry.php
   │     │     ├─ Event
   │     │     │  ├─ LifecycleEventArgs.php
   │     │     │  ├─ LoadClassMetadataEventArgs.php
   │     │     │  ├─ ManagerEventArgs.php
   │     │     │  ├─ OnClearEventArgs.php
   │     │     │  └─ PreUpdateEventArgs.php
   │     │     ├─ ManagerRegistry.php
   │     │     ├─ Mapping
   │     │     │  ├─ AbstractClassMetadataFactory.php
   │     │     │  ├─ ClassMetadata.php
   │     │     │  ├─ ClassMetadataFactory.php
   │     │     │  ├─ Driver
   │     │     │  │  ├─ ColocatedMappingDriver.php
   │     │     │  │  ├─ DefaultFileLocator.php
   │     │     │  │  ├─ FileDriver.php
   │     │     │  │  ├─ FileLocator.php
   │     │     │  │  ├─ MappingDriver.php
   │     │     │  │  ├─ MappingDriverChain.php
   │     │     │  │  ├─ PHPDriver.php
   │     │     │  │  ├─ StaticPHPDriver.php
   │     │     │  │  └─ SymfonyFileLocator.php
   │     │     │  ├─ MappingException.php
   │     │     │  ├─ ProxyClassNameResolver.php
   │     │     │  ├─ ReflectionService.php
   │     │     │  ├─ RuntimeReflectionService.php
   │     │     │  └─ StaticReflectionService.php
   │     │     ├─ NotifyPropertyChanged.php
   │     │     ├─ ObjectManager.php
   │     │     ├─ ObjectManagerDecorator.php
   │     │     ├─ ObjectRepository.php
   │     │     ├─ PropertyChangedListener.php
   │     │     ├─ Proxy.php
   │     │     └─ Reflection
   │     │        ├─ EnumReflectionProperty.php
   │     │        ├─ RuntimePublicReflectionProperty.php
   │     │        ├─ RuntimeReflectionProperty.php
   │     │        ├─ TypedNoDefaultReflectionProperty.php
   │     │        ├─ TypedNoDefaultReflectionPropertyBase.php
   │     │        └─ TypedNoDefaultRuntimePublicReflectionProperty.php
   │     └─ UPGRADE.md
   ├─ mercadopago
   │  └─ dx-php
   │     ├─ .travis.yml
   │     ├─ composer.json
   │     ├─ img
   │     │  ├─ demo.svg
   │     │  └─ ezgif-2-f98e8701825e.gif
   │     ├─ LICENSE
   │     ├─ phpunit.phar
   │     ├─ phpunit.xml
   │     ├─ README.md
   │     ├─ samples
   │     │  ├─ checkout-buttons
   │     │  │  ├─ basic-preference
   │     │  │  │  └─ button.php
   │     │  │  └─ full-preference
   │     │  │     └─ button.php
   │     │  ├─ composer.json
   │     │  ├─ composer.lock
   │     │  ├─ customer-and-cards
   │     │  │  ├─ card
   │     │  │  │  └─ list.php
   │     │  │  └─ customer
   │     │  │     ├─ create.php
   │     │  │     └─ remove.php
   │     │  ├─ index.php
   │     │  ├─ payment
   │     │  │  └─ minimal
   │     │  │     ├─ create.php
   │     │  │     └─ refund.php
   │     │  └─ suscriptions
   │     │     └─ basic-suscription.php
   │     ├─ src
   │     │  └─ MercadoPago
   │     │     ├─ Annotation
   │     │     │  ├─ Attribute.php
   │     │     │  ├─ DenyDynamicAttribute.php
   │     │     │  ├─ RequestParam.php
   │     │     │  └─ RestMethod.php
   │     │     ├─ Config
   │     │     │  ├─ AbstractConfig.php
   │     │     │  ├─ Json.php
   │     │     │  ├─ ParserInterface.php
   │     │     │  └─ Yaml.php
   │     │     ├─ Config.php
   │     │     ├─ Entities
   │     │     │  ├─ AdvancedPayments
   │     │     │  │  ├─ AdvancedPayment.php
   │     │     │  │  ├─ DisbursementRefund.php
   │     │     │  │  └─ Refund.php
   │     │     │  ├─ AuthorizedPayment.php
   │     │     │  ├─ Card.php
   │     │     │  ├─ CardToken.php
   │     │     │  ├─ Chargeback.php
   │     │     │  ├─ Customer.php
   │     │     │  ├─ DiscountCampaign.php
   │     │     │  ├─ InstoreOrder.php
   │     │     │  ├─ Invoice.php
   │     │     │  ├─ MerchantOrder.php
   │     │     │  ├─ OAuth.php
   │     │     │  ├─ Plan.php
   │     │     │  ├─ POS.php
   │     │     │  ├─ Preapproval.php
   │     │     │  ├─ Preference.php
   │     │     │  ├─ Refund.php
   │     │     │  ├─ Shared
   │     │     │  │  ├─ Documentation.php
   │     │     │  │  ├─ Item.php
   │     │     │  │  ├─ Payer.php
   │     │     │  │  ├─ Payment.php
   │     │     │  │  ├─ PaymentMethod.php
   │     │     │  │  ├─ Tax.php
   │     │     │  │  ├─ Track.php
   │     │     │  │  └─ TrackValues.php
   │     │     │  ├─ Shipments.php
   │     │     │  └─ Subscription.php
   │     │     ├─ Entity.php
   │     │     ├─ Generic
   │     │     │  ├─ ErrorCause.php
   │     │     │  ├─ RecuperableError.php
   │     │     │  └─ SearchResultsArray.php
   │     │     ├─ Http
   │     │     │  ├─ CurlRequest.php
   │     │     │  └─ HttpRequest.php
   │     │     ├─ Manager.php
   │     │     ├─ MetaDataReader.php
   │     │     ├─ RestClient.php
   │     │     ├─ SDK.php
   │     │     └─ Version.php
   │     └─ tests
   │        ├─ config_files
   │        │  ├─ settings.ini
   │        │  ├─ settings.json
   │        │  ├─ settings.yml
   │        │  ├─ settings_broken.json
   │        │  └─ settings_broken.yml
   │        ├─ DummyEntity.php
   │        ├─ FakeApiHub.php
   │        ├─ json_files
   │        │  ├─ authorization.json
   │        │  ├─ customer_search.json
   │        │  ├─ dummies.json
   │        │  ├─ dummy.json
   │        │  └─ payment.json
   │        ├─ MercadoPagoSdkTest.php
   │        ├─ resources
   │        │  ├─ PaymentTest.php
   │        │  └─ PreferenceTest.php
   │        └─ SDKTest.php
   └─ psr
      └─ cache
         ├─ CHANGELOG.md
         ├─ composer.json
         ├─ LICENSE.txt
         ├─ README.md
         └─ src
            ├─ CacheException.php
            ├─ CacheItemInterface.php
            ├─ CacheItemPoolInterface.php
            └─ InvalidArgumentException.php

```