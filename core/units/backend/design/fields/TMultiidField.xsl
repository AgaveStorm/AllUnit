<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="utf-8" indent="no"/>
    <xsl:template match="*[type='multiid']">
        <xsl:param name="value"/>
        <div class="id-field" 
            data-list="{list}" 
            data-name="{name}"
            data-value="{$value}"
            data-multiid="multiid">
            <xsl:attribute name="data-value">
                <xsl:for-each select="$value/ids/item"><xsl:value-of select="."/>/</xsl:for-each>
            </xsl:attribute>
        </div>
    </xsl:template>
</xsl:stylesheet>
