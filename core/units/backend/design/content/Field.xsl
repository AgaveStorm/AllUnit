<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="utf-8" indent="no"/>
    <xsl:template name="Field">
        <xsl:param name="field"/>
        <xsl:param name="value"/>
        <div class="field field-{$field/name} field-type-{$field/type}" title="{$field/title}">
            <div class="inner">
                <xsl:value-of select="$value"/>
            </div>
        </div>
    </xsl:template>
</xsl:stylesheet>
