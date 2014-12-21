<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="utf-8" indent="no"/>
    <xsl:template name="Field">
        <xsl:param name="field"/>
        <xsl:param name="value"/>
        <div class="field field-{$field/name} field-type-{$field/type}" title="{$field/title}">
            <div class="inner">
                <xsl:choose>
                    <xsl:when test="$field/type = 'img'">
                        <img src="{//siteurl}/vhfiles?file={$value}&amp;w=100"/>
                    </xsl:when>
                    <xsl:otherwise>
                        <xsl:value-of select="$value"/>
                    </xsl:otherwise>
                </xsl:choose>
            </div>
        </div>
    </xsl:template>
</xsl:stylesheet>
